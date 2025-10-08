<?php

namespace App\Data\Requests\Product;

use Spatie\LaravelData\Data;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "AttributeFilterData",
    description: "Фильтр по атрибуту (например, цвет, объем памяти)",
)]
class AttributeFilterData extends Data
{
    #[OA\Property(type: "string", description: "Название атрибута (например, color, storage)", example: "color")]
    public string $name;

    #[OA\Property(type: "array", items: new OA\Items(type: "string", example: "[red, blue]"))]
    /** @var string[] */
    public array $values;
}

