<?php

namespace App\Data\Responses\Product;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "ProductData")]
class ProductData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public int $minPrice,
        public int $maxPrice,
        public ?string $description,

        /** @var Collection<int, ProductVariantData> */
        public Collection $variants,
        public array $category
    ) {}

    public static function fromModel(Product $product): self
    {
        return new self(
            id: $product->id,
            name: $product->name,
            description: $product->description,
            minPrice: $product->min_price,
            maxPrice: $product->max_price,
            variants: ProductVariantData::collect($product->variants),
            category: [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'description' => $product->category->description,
                'parentCategory' => $product->category->parent->name ?? null,
            ]
        );
    }
}