<?php

namespace App\Data\Responses\Cart;

use App\Data\BaseData;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "CartData",
)]
class CartData extends BaseData
{
    public function __construct(
        
        #[OA\Property(
            type: "array",
            items: new OA\Items(ref: '#/components/schemas/CartItemDataWithSubtotal')
        )]
        public Collection $items,
        
        #[OA\Property(
            type: 'object',
            properties: [
                new OA\Property(property: "totalItems", type: "integer", example: 5),
                new OA\Property(property: "totalSelected", type: "integer", example: 3),
                new OA\Property(property: "totalAmount", type: "number", format: "float", example: 249.95),
                new OA\Property(property: "selectedAmount", type: "number", format: "float", example: 149.97),
            ],
        )]
        public array $summary,
    ) {}
    
    public static function fromModel(Cart $cart): self
    {
        /** @var Collection<int, CartItemData> */
        $cartitemsdata =  CartItemData::collect($cart->items);
        
        return new self(

            items: $cartitemsdata,
            summary: [
                'totalItems' => $cart->items->sum('quantity'),
                'totalSelected' => $cart->items->where('is_selected', true)->sum('quantity'),
                'totalAmount' => $cart->items->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                }),
                'selectedAmount' => $cart->items->where('is_selected', true)->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                }),
            ],
        );
    }
}