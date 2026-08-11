<?php
namespace App\Repositories;

use App\Interfaces\CartInterface;
use App\Models\Cart;

class CartInterfaceRepository implements CartInterface
{
    public function getCart(int $userId)
    {
        return Cart::with('cartItems.product')
            ->where('user_id', $userId)
            ->first();
    }
}
