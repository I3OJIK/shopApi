<?php

namespace App\Data\Responses\Product;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use App\Models\Product;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "ProductData")]
class ProductData extends Data
{
    public function __construct(
        #[OA\Property(example: 1)]
        public int $id,

        #[OA\Property(example: "iPhone 15")]
        public string $name,

        #[OA\Property(example: "Latest smartphone")]
        public ?string $description,

        #[OA\Property(property: "minPrice", example: 79900)]
        public int $minPrice,

        #[OA\Property(property: "maxPrice", example: 149900)]
        public int $maxPrice,

        #[OA\Property(
            property: "variants",
            type: "array",
            items: new OA\Items(ref: "#/components/schemas/ProductVariantData")
        )]
        #[DataCollectionOf(ProductVariantData::class)]
        public DataCollection $variants,

        #[OA\Property(
            property: "categories", 
            type: "array",
            items: new OA\Items(type: "object")
        )]
        public array $categories
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
        categories: $product->categories->map(fn($category) => [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
        ])->toArray()
    );
}
}