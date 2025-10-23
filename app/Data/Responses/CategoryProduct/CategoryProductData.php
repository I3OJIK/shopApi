<?php

namespace App\Data\Responses\CategoryProduct;

use App\Data\Responses\Category\CategoryData;
use App\Data\Responses\Product\Views\ProductListData;
use App\Models\Category;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\PaginatedDataCollection;

#[OA\Schema(schema: "CategoryProductData")]
class CategoryProductData extends Data
{
    public function __construct(
        /** @var PaginatedDataCollection<int, ProductListData> */
        #[OA\Property(
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/ProductListData'),
            nullable: true
        )]
        public PaginatedDataCollection $products,

        /** @var ?DataCollection<int, CategoryData> */
        #[OA\Property(
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/CategoryData'),
            nullable: true
        )]
        #[MapOutputName(SnakeCaseMapper::class)]
        public ?DataCollection $childrenCategories,
    ) {}

    public static function fromModel(Category $category, LengthAwarePaginator $products): self
    {
        // Если категория родительская (parent_id === null), получаем дочерние категории
        $children = $category->parent_id === null ? $category->children : null;

        return new self(
            products: ProductListData::collect($products, PaginatedDataCollection::class),
            childrenCategories: CategoryData::collect($children, DataCollection::class),
        );
    }
}