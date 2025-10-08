<?php

namespace App\Data\Requests\Product;

use App\Data\BaseData;
use App\Data\Requests\Product\AttributeFilterData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\In;
use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;

#[OA\Schema(
    schema: "ProductFilterData",
)]
class ProductFilterData extends BaseData
{
    #[OA\Property(type: "string", example: "Apple")]
    public ?string $search;

    #[OA\Property(type: "int", example: "2")]
    public ?int $categoryId;

    #[OA\Property(type: "array", items: new OA\Items(ref: "#/components/schemas/AttributeFilterData"))]
    #[DataCollectionOf(AttributeFilterData::class)]
    public ?array $attributes;

    #[OA\Property(ref: "#/components/schemas/PriceRangeFilterData")]
    public ?PriceRangeFilterData $priceRange;

    #[OA\Property(type: "string", example: "price_desc")]
    #[In('price_asc', 'price_desc', 'name_asc', 'name_desc')]
    public ?string $sort;

    #[OA\Property(type: "int", example: "1")]
    #[Min(20), Max(100)]
    public ?int $perPage = 20;

}
