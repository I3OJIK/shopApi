<?php

namespace App\Data\Models;

use App\Models\ProductGroup;
use Spatie\LaravelData\Data;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "ProductGroupData", description: "Базовая информация о группе продуктов")]
class ProductGroupData extends Data
{
    public function __construct(
        #[OA\Property(type: 'integer', example: 5)]
        public int $id,

        #[OA\Property(type: 'string', example: 'Iphone 14')]
        public string $name,

        #[OA\Property(type: 'string', example: 'Описание группы продуктов')]
        public string $description,
    ) {}
}
