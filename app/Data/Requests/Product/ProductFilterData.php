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
    public function __construct(
        #[OA\Property(type: "string", example: "Apple")]
        public ?string $search,

        #[OA\Property(type: "int", example: "15291")]
        #[MapInputName(SnakeCaseMapper::class)]
        public ?int $minPrice,

        #[OA\Property(type: "int", example: "15291")]
        #[MapInputName(SnakeCaseMapper::class)]
        public ?int $maxPrice,

        #[OA\Property(type: "string", example: "price_desc")]
        #[In('price_asc', 'price_desc', 'name_asc', 'name_desc')]
        public ?string $sort,

        #[OA\Property(type: "int", example: "1")]
        #[Min(20), Max(100)]
        #[MapInputName(SnakeCaseMapper::class)]
        public ?int $perPage = 20,
    ) {}

}