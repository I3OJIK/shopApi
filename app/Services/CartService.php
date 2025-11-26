<?php

namespace App\Services;

use App\Data\Requests\Product\CategoryProductFilterData;
use App\Filters\Product\CategoryProductFilter;
use App\Models\Cart;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;

class CartService
{

    public function getCart(): Cart
    {
        $userId = auth()->user()->id;

        $cart = Cart::with(['items.product'])
            ->firstOrCreate(['user_id' => $userId]);
        
        return $cart;
    }


}