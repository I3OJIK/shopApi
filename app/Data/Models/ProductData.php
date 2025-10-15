<?php

namespace App\Data\Models;

use App\Data\BaseData;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ProductData",
)]
class ProductData extends BaseData
{
    public function __construct(
        #[OA\Property(type: 'integer', example: 1)]
        public int $id,

        #[OA\Property(type: 'string', example: 'Iphone 14 256GB, red, Limited Edition')]
        public string $name,

        #[OA\Property(type: 'string', example: '256GB')]
        public string $size,

        #[OA\Property(type: 'string', example: 'Red')]
        public string $color,

        #[OA\Property(type: 'string', nullable: true, example: 'Limited Edition')]
        public ?string $variant,

        #[OA\Property(type: 'string', nullable: true, example: 'https://example.com/image.jpg')]
        public ?string $image,

        #[OA\Property(type: 'integer', example: 1999)]
        public int $price,

        #[OA\Property(type: 'integer', example: 10)]
        public int $stock,
    ) {}
}