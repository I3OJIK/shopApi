<?php

namespace App\Data\Requests\Cart;

use App\Data\BaseData;
use Spatie\LaravelData\Attributes\Validation\In;
use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[OA\Schema(
    schema: "AddItemData",
)]
class AddItemData extends BaseData
{
    public function __construct(

        #[OA\Property(type: "int", example: "1",  property: "product_id")]
        #[MapInputName(SnakeCaseMapper::class)]
        #[Exists('products', 'id')]
        public int $productId,

        #[OA\Property(type: "int", example: "20")]
        #[Min(1)]
        public ?int $quantity = 1,
    ) {}

}