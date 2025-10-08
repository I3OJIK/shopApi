<?php

namespace App\Data\Requests\Product;

use Spatie\LaravelData\Data;
use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\Validation\Min;

#[OA\Schema(
    schema: "PriceRangeFilterData",
    description: "Фильтр по цене от и до",
)]
class PriceRangeFilterData extends Data
{
    #[OA\Property(type: "int", example: "20")]
    #[Min(0)]
    public ?int $min;

    #[OA\Property(type: "int", example: "10000")]
    #[Min(0)]
    public ?int $max;
}

