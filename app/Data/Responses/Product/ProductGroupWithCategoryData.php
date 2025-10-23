<?php

namespace App\Data\Responses\Product;

use App\Data\Responses\Category\CategoryWithParentData;
use App\Models\ProductGroup;
use Spatie\LaravelData\Data;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "ProductGroupCategoryData", description:"Дерево productGroup и категорий")]
class ProductGroupWithCategoryData extends Data
{
    public function __construct(
        #[OA\Property(type: 'integer', example: 1)]
        public int $id,

        #[OA\Property(type: 'string', example: 'Iphone 14')]
        public string $name,

        #[OA\Property(type: 'string', example: 'description')]
        public string $description,

        #[OA\Property(ref: '#/components/schemas/CategoryWithParentData')]
        public CategoryWithParentData $category
    ) {}

    public static function fromModel(ProductGroup $productGroup): self
    {
        return new self(
            id: $productGroup->id,
            name: $productGroup->name,
            description: $productGroup->description,
            category: CategoryWithParentData::from($productGroup->category)
        );
    }
}
