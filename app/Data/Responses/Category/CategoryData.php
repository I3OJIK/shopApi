<?php

namespace App\Data\Responses\Category;

use App\Models\Category;
use Spatie\LaravelData\Data;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "CategoryData")]
class CategoryData extends Data
{
    public function __construct(
        #[OA\Property(example: 1)]
        public int $id,

        #[OA\Property(example: "Электроника")]
        public string $name,

        #[OA\Property(example: "Товары для дома и техники")]
        public ?string $description = null,
    ) {}

    public static function fromModel(Category $category): self
    {
        return new self(
            id: $category->id,
            name: $category->name,
            description: $category->description,
        );
    }
}
