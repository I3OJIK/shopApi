<?php

namespace App\Data\Responses\Product;

use Spatie\LaravelData\Data;
use App\Models\Product;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "ProductData")]
class ProductListData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $size,
        public string $color,
        public ?string $variant,
        public ?string $image,
        public int $price,
        public int $stock,

        public array $product_group,
    ) {}

    public static function fromModel(Product $product): self
    {
        return new self(
            id: $product->id,
            name: $product->name,
            size: $product->size,
            color: $product->color,
            variant: $product->variant,
            image: $product->image,
            price: $product->price,
            stock: $product->stock,
            product_group: [
                'id' => $product->productGroup->id,
                'name' => $product->productGroup->name,
                'category' => [
                    'id' => $product->productGroup->category->id,
                    'name' => $product->productGroup->category->name,
                ]
            ],
        );
    }
}