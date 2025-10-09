<?php

namespace App\Data\Responses\Product;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Collection;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "ProductVariantData")]
class ProductVariantData extends Data
{
    public function __construct(
        public int $id,
        public string $sku,
        public int $price,
        public int $stock,

        /** @var Collection<int, AttributeValueData> */
        public Collection $attributes
    ) {}

    public static function fromModel(ProductVariant $variant): self
    {
        return new self(
            id: $variant->id,
            sku: $variant->sku,
            price: $variant->price,
            stock: $variant->stock,
            attributes: AttributeValueData::collect($variant->attributeValues)
        );
    }
}