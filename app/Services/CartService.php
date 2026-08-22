<?php

namespace App\Services;

use App\Exceptions\InsufficientStockException;
use App\Interfaces\CartInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CartInterface $cart_interface
    ) {}

    /**
     * handles cart and adding of item
     *
     * @param integer $userId
     * @param integer $productId
     * @return void
     */
    public function addToCart(int $userId, int $productId, int $quantity)
    {
        return DB::transaction(function () use ($userId, $productId, $quantity) {

            $cart = $this->cart_interface->getOrCreateCart($userId);

            $product = Product::lockForUpdate()->findOrFail($productId);

            $item = $cart->cartItems()
                ->where('product_id', $productId)
                ->first();

            if ($quantity + $item->quantity > $product->stock) {
                throw new InsufficientStockException();
            }

            return $this->cart_interface->addItem($cart, $productId, $quantity, $item );

        });

    }
}
