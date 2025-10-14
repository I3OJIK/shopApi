<?php

namespace App\Data\Responses\Product;

use Spatie\LaravelData\Data;
use App\Models\Product;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "ProductListData")]
class ProductListData extends Data
{
    public function __construct(
        #[OA\Property(type: 'integer', example: 1)]
        public int $id,

        #[OA\Property(type: 'string', example: 'Iphone 14 256GB, red, Limited Edition')]
        public string $name,

        #[OA\Property(type: 'string', example: '256GB')]
        public string $size,

        #[OA\Property(type: 'string', example: 'Red')]
        public string $color,

        #[OA\Property(type: 'string', nullable: true, example: 'Limited Edition')]
        public ?string $variant,

        #[OA\Property(type: 'string', nullable: true, example: 'https://example.com/image.jpg')]
        public ?string $image,

        #[OA\Property(type: 'integer', example: 1999)]
        public int $price,

        #[OA\Property(type: 'integer', example: 10)]
        public int $stock,

        #[OA\Property(
            type: 'object',
            description: 'Группа продукта',
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 5),
                new OA\Property(property: 'name', type: 'string', example: 'Iphone 14'),
                new OA\Property(property: 'category', type: 'object', properties: [
                    new OA\Property(property: 'id', type: 'integer', example: 2),
                    new OA\Property(property: 'name', type: 'string', example: 'Smartfones'),
                ])
            ]
        )]
        public array $product_group,
    ) {}

    public static function fromModel(Product $product): self
    {
        return new self(
            id: $product->id,
            name: $product->name,
            size: $product->size,
            color: $product->color,
            variant: $product->variant,
            image: $product->image,
            price: $product->price,
            stock: $product->stock,
            product_group: [
                'id' => $product->productGroup->id,
                'name' => $product->productGroup->name,
                'category' => [
                    'id' => $product->productGroup->category->id,
                    'name' => $product->productGroup->category->name,
                ]
            ],
        );
    }
}