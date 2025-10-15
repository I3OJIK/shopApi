<?php

namespace App\Data\Responses\Product\Show;

use App\Models\ProductGroup;
use Spatie\LaravelData\Data;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "ProductGroupCategoryTree", description:"Дерево productGroup и категорий")]
class ProductGroupCategoryTree extends Data
{
    public function __construct(
        #[OA\Property(type: 'integer', example: 1)]
        public int $id,

        #[OA\Property(type: 'string', example: 'Iphone 14')]
        public string $name,

        #[OA\Property(type: 'string', example: 'description')]
        public string $description,

        #[OA\Property(
            type: 'object',
            description: 'Категории',
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 5),
                new OA\Property(property: 'name', type: 'string', example: 'smartfones'),
                new OA\Property(property: 'parent', type: 'object', properties: [
                    new OA\Property(property: 'id', type: 'integer', example: 2),
                    new OA\Property(property: 'name', type: 'string', example: 'Iphone 14'),
                ])
            ]
        )]
        public array $category
    ) {}

    public static function fromModel(ProductGroup $productGroup): self
    {
        return new self(
            id: $productGroup->id,
            name: $productGroup->name,
            description: $productGroup->description,
            category: [
                'id' => $productGroup->category->id,
                'name' => $productGroup->category->name,
                'parent' => [
                    'id' => $productGroup->category->parent->id,
                    'name' => $productGroup->category->parent->name,
                ]
            ],
        );
    }
}
