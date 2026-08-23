<?php

namespace App\Interfaces;

use App\Models\Cart;

interface CartInterface
{
    public function getCart(int $userId);

    public function getOrCreateCart(int $userId);

    public function addItem(Cart $cart, int $productId, int $quantity, $item);

    public function clearCart($cart);

    public function getBook($bookId);
}
