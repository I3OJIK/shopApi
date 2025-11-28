<?php

namespace App\Services;

use App\Data\Requests\Cart\AddItemData;
use App\Data\Requests\Cart\UpdateItemQuantityData;
use App\Exceptions\CartEmptyException;
use App\Exceptions\InsufficientStockException;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\error;

class CartService
{

    /**
     * Получение корзины пользователя c жадной загрузкой items.product
     * 
     * @return Cart
     */
    public function getUserCartWithProduct(): Cart
    {
        $userId = Auth::id();

        $cart = Cart::with('items.product')->firstOrCreate(['user_id' => $userId]);
        
        return $cart;
    }

    /**
     * Получение корзины пользователя 
     * 
     * @return Cart
     */
    public function getUserCart(): Cart
    {
        $userId = Auth::id();

        $cart = Cart::with('items')->firstOrCreate(['user_id' => $userId]);
        
        return $cart;
    }

    /**
     * Добавление товара в корзину
     * 
     * @param int $productId
     * @param int $quantity
     * 
     * @return void
     */
    public function addItem(AddItemData $addItemData): void
    {
        $product = Product::findOrFail($addItemData->productId);
        $quantity = $addItemData->quantity;

        $this->validateStock($product, $addItemData->quantity);

        DB::transaction(function () use ($product, $quantity) {
            $cart = $this->getUserCart();

            $cartItem = $cart->items
                ->where('product_id', $product->id)
                ->first();

            //если товар уже есть в корзине то обновляем количество и еще раз проверяем 
            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $quantity;
        
                $this->validateStock($product, $quantity);
        
                $cartItem->update(['quantity' => $newQuantity]);

            } else {
                // Если товара нет в корзине - создаём
                CartItem::create([
                    'cart_id'    => $cart->id,
                    'product_id' => $product->id,
                    'quantity'   => $quantity,
                    'is_selected' => $cart->is_all_selected
                ]);
            }
        });
    }

    /**
     * Обновление кол-ва товара в корзине
     * 
     * @param int $itemId
     * @param int $quantity
     * 
     * @return void
     */
    public function updateItemQuantity(int $itemId, int $quantity): void
    {
        $cartItem = $this->getUserCartItem($itemId);
        
        $this->validateStock($cartItem->product, $quantity);
        
        $cartItem->update(['quantity' => $quantity]);
    }


    /**
     * Удаление item из корзины
     * 
     * @param int $itemId
     * 
     * @return void
     */
    public function deleteItem(int $itemId): void
    {
        $cartItem = $this->getUserCartItem($itemId);
        $cartItem->delete();
    }

    /**
     * Изменение флажка выбран/не выбран товар
     * 
     * @param int $itemId
     * 
     * @return void
     */
    public function selectItem(int $itemId): void
    {
        DB::transaction(function () use($itemId) {
            $cartItem = $this->getUserCartItem($itemId);
            
            $cartItem->update(['is_selected' => !$cartItem->is_selected]);
            if(!$cartItem->is_selected == 'false') {
                $cartItem->cart->update(['is_all_selected' => false]);
            }
        });
    }


    /**
     * Выбор/отменение выбора всех товаров в корзине
     * 
     * @return void
     */
    public function selectAllItems(): void
    {
        DB::transaction(function () {
            $cart = $this->getUserCart();
            
            $cart->items()->update(['is_selected' => !$cart->is_all_selected]);
            $cart->update(['is_all_selected' => !$cart->is_all_selected]);
        });
    }

    /**
     * Полная очистка корзины
     * 
     * @param int $itemId
     * 
     * @return void
     */
    public function clearCart(): void
    {
        DB::transaction(function () {
            $cart = $this->getUserCart();

            // Проверяем наличие товаров и удаляем в одном запросе
            $deletedCount = $cart->items()->delete();
            
            if ($deletedCount === 0) {
                throw new CartEmptyException();
            }
            
            // Обновляем флаг только если он был true
            if ($cart->is_all_selected) {
                $cart->update(['is_all_selected' => false]);
            }
        });
    }

    /**
     * Удаление выбранных товаров в корзине
     * 
     * @return void
     */
    public function clearSelectedItems(): void
    {
        DB::transaction(function () {
            $cart = $this->getUserCart();

            $deletedCount = $cart->items()
                ->where('is_selected', true)
                ->delete();
            
            if ($deletedCount === 0) {
                throw new CartEmptyException('No selected items to remove');
            }
            
            // Обновляем флаг только если он был true
            if ($cart->is_all_selected) {
                $cart->update(['is_all_selected' => false]);
            }
        });
    }

    /**
     * Проверка остатков товара и кол-ва товара в корзине
     * 
     * @param Product $product
     * @param int $quantity
     * 
     * @return void
     */
    private function validateStock(Product $product, int $quantity): void
    {
        if ($quantity > $product->stock) {
            throw new InsufficientStockException($product->stock);
        }
    }

    /**
     * Получение cartItem текущего пользователя
     */
    private function getUserCartItem(int $itemId): CartItem
    {
        return CartItem::whereHas('cart', function($query) {
            $query->where('user_id', Auth::id());
        })
        // ->with('product')
        ->where('id', $itemId)
        ->firstOrFail();
    }

}