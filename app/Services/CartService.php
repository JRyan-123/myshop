<?php

namespace App\Services;

use App\Interfaces\CartInterface;

class CartService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CartInterface $cart_interface
    ) {}

    /**
     * handles create cart and add item to cart
     *
     * @param integer $userId
     * @param integer $productId
     * @return void
     */
    public function addToCart(int $userId, int $productId)
    {
        $cart = $this->cart_interface->getOrCreateCart($userId);

        return $this->cart_interface->addItem($cart, $productId);
    }
}
