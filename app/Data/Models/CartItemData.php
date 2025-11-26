<?php

namespace App\Data\Models;

use App\Data\BaseData;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "CartItemData",
)]
class CartItemData extends BaseData
{
    public function __construct(
        #[OA\Property(type: "integer", example: 1)]
        public int $id,

        #[OA\Property(type: "string", example: 1)]
        public int $cartId,

        #[OA\Property(type: "string", example: 1)]
        public int $productId,

        #[OA\Property(type: "string", example: 1)]
        public int $quantity,

        #[OA\Property(type: "string", example: 1)]
        public int $isSelected,

        #[OA\Property(type: "string", format: "date-time", example: "2025-10-03 13:41:09")]
        public ?string $createdAt,

        #[OA\Property(type: "string", format: "date-time", example: "2025-10-03 13:41:09")]
        public ?string $updatedAt,
    ) {}
}