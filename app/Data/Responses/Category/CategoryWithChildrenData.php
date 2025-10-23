<?php

namespace App\Data\Responses\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Data;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "CategoryWithChildrenData")]
class CategoryWithChildrenData extends Data
{
    public function __construct(
        #[OA\Property(example: 1)]
        public int $id,

        #[OA\Property(example: "Электроника")]
        public string $name,

        #[OA\Property(example: "Техника и гаджеты")]
        public ?string $description = null,

        /** @var Collection<int, CategoryData> */
        #[OA\Property(
            type: "array",
            items: new OA\Items(ref: '#/components/schemas/CategoryData')
        )]
        public Collection $children
    ) {}

    public static function fromModel(Category $category): self
    {
        return new self(
            id: $category->id,
            name: $category->name,
            description: $category->description,
            children: CategoryData::collect($category->children)
        );
    }
}
