<?php

namespace App\Data\Responses\Product;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use App\Models\ProductVariant;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "ProductVariantData")]
class ProductVariantData extends Data
{
    public function __construct(
        #[OA\Property(example: 1)]
        public int $id,

        #[OA\Property(example: "IPH15-RED-128")]
        public string $sku,

        #[OA\Property(example: 79900)]
        public float $price,

        #[OA\Property(example: 50)]
        public int $stock,

        #[OA\Property(
            property: "attributes",
            type: "array", 
            items: new OA\Items(ref: "#/components/schemas/AttributeData")
        )]
        #[DataCollectionOf(AttributeData::class)]
        public DataCollection $attributes // ← Изменили на DataCollection
    ) {}

    public static function fromModel(ProductVariant $variant): self
    {
        return new self(
            id: $variant->id,
            sku: $variant->sku,
            price: $variant->price,
            stock: $variant->stock,
            attributes: ProductAttributeData::collect( // ← Используем collect для DataCollection
                $variant->attributeValues->map(function ($attributeValue) {
                    return [
                        'id' => $attributeValue->id,
                        'name' => $attributeValue->attribute->name,
                        'value' => $attributeValue->value,
                        'attributeId' => $attributeValue->attribute->id,
                    ];
                })
            )
        );
    }
}