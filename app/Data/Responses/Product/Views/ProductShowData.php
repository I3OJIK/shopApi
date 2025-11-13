<?php

namespace App\Data\Responses\Product\Views;

use App\Data\Models\ProductData;
use App\Data\Responses\Product\ProductGroupWithCategoryData;
use App\Data\Responses\Product\ProductVariantData;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Data;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "ProductShowData", description:"Продукт, его доступные варианты, дерево productGroup и категорий")]
class ProductShowData extends Data
{
    public function __construct(
        #[OA\Property(ref: '#/components/schemas/ProductData')]
        public ProductData $product,

        #[OA\Property(
            type: "array",
            items: new OA\Items(ref: '#/components/schemas/ProductVariantData')
        )]
        /** @var Collection<int, ProductVariantData> */
        public Collection $variants,

        #[OA\Property(ref: '#/components/schemas/ProductGroupCategoryTree')]
        public ProductGroupWithCategoryData $productGroup,
    ) {}

    public static function fromModelWithVariants(Product $product): self
    {
        // Исключаем текущий товар из вариантов
        $variants = $product->productGroup->products
            ->where('id', '!=', $product->id);

        /** @var Collection<int, ProductVariantData> */
        $variants = ProductVariantData::collect($variants);

        return new self(
            product: ProductData::from($product),
            variants: $variants,
            productGroup: ProductGroupWithCategoryData::from($product->productGroup)
        );
    }

   
}