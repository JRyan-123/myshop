<?php

namespace App\Repositories;

use App\Interfaces\CartInterface;
use App\Models\Cart;
use App\Models\Product;

class CartRepository implements CartInterface
{
    /**
     * fetch cart items
     *
     * @param integer $userId
     * @return void
     */
    public function getCart(int $userId)
    {
        return Cart::with('cartItems.product')
            ->where('user_id', $userId)
            ->first();
    }



    /**
     * fetch the cart or create one
     *
     * @param integer $userId
     * @return void
     */
    public function getOrCreateCart(int $userId)
    {
        return Cart::firstOrCreate([
            'user_id' => $userId,
        ]);
    }



    /**
     * check for existing product in the cart else add the item to cart
     *
     * @param [type] $cart
     * @param integer $productId
     * @return void
     */
    public function addItem(Cart $cart, int $productId, int $quantity, $item)
    {
        if ($item) {
            $item->increment('quantity', $quantity);
        } else {
            $cart->cartItems()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return $cart->fresh('cartItems.product');
    }


    /**
     * Undocumented function
     *
     * @param [type] $cart
     * @return void
     */
    public function clearCart($cart)
    {
        $cart->delete();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getBook($bookId) {
        return Product::where('id', $bookId)
            ->first();
    }
}
