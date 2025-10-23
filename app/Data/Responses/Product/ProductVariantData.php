<?php

namespace App\Data\Responses\Product;

use Spatie\LaravelData\Data;
use OpenApi\Attributes as OA;


#[OA\Schema(schema: "ProductVariantData", description:"Доступные варианты продукта (сортировка по productGroup)")]
class ProductVariantData extends Data
{
    public function __construct(
        #[OA\Property(type: 'integer', example: 1)]
        public int $id,

        #[OA\Property(type: 'string', example: '256GB')]
        public string $size,

        #[OA\Property(type: 'string', example: 'Red')]
        public string $color,

        #[OA\Property(type: 'string', nullable: true, example: 'Limited Edition')]
        public ?string $variant,
    ) {}
}