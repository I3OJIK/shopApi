<?php

namespace App\Data\Requests\Product;

use App\Data\BaseData;
use Spatie\LaravelData\Attributes\Validation\In;
use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[OA\Schema(
    schema: "ProductFilterData",
)]
class ProductFilterData extends BaseData
{
    #[OA\Property(type: "string", example: "Apple")]
    public ?string $search;

    #[OA\Property(
        type: "string", 
        example: "15291-99990",
        description: "Price range in format 'min-max'. Examples: '1000-50000', '1000-' (min only), '-50000' (max only)"
    )]
    #[MapInputName(SnakeCaseMapper::class)]
    public ?string $priceRange;

    #[OA\Property(type: "string", example: "price_desc")]
    #[In('price_asc', 'price_desc', 'name_asc', 'name_desc')]
    public ?string $sort;

    #[OA\Property(type: "int", example: "1")]
    #[Min(20), Max(100)]
    public ?int $perPage = 20;

}