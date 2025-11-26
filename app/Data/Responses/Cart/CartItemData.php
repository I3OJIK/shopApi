<?php

namespace App\Data\Responses\Cart;

use App\Data\BaseData;
use App\Data\Models\ProductData;
use App\Models\CartItem;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "CartItemDataWithSubtotal",
)]
class CartItemData extends BaseData
{
    public function __construct(
        #[OA\Property(type: "integer", example: 1)]
        public int $id,

        #[OA\Property(ref: '#/components/schemas/ProductData')]
        public ProductData $product,

        #[OA\Property(type: "int", example: 1)]
        public int $quantity,

        #[OA\Property(type: "string", example: 'true')]
        public bool $isSelected,

        #[OA\Property(type: "int", example: 1)]
        public int $subtotal,

        #[OA\Property(type: "string", format: "date-time", example: "2025-10-03 13:41:09")]
        public ?string $createdAt,

        #[OA\Property(type: "string", format: "date-time", example: "2025-10-03 13:41:09")]
        public ?string $updatedAt,
    ) {}
    public static function fromModel(CartItem $cartItems): self
    {
        return new self(
            id: $cartItems->id,
            product: ProductData::from($cartItems->product),
            quantity: $cartItems->quantity,
            isSelected: $cartItems->is_selected,
            subtotal: $cartItems->quantity * $cartItems->product->price,
            createdAt: $cartItems->created_at,
            updatedAt: $cartItems->updated_at,
        );
    }
}