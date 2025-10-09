<?php

namespace App\Data\Responses\Product;

use App\Models\AttributeValue;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use App\Models\ProductVariant;
use OpenApi\Attributes as OA;

class AttributeValueData extends Data
{
    public function __construct(
        // public int $id,
        public string $name,
        public string $value,
    ) {}

    public static function fromModel(AttributeValue $attributeValue): self
    {
        return new self(
            // id: $variant->id,
            name: $attributeValue->attribute->name,
            value: $attributeValue->value,
        );
    }
        
}