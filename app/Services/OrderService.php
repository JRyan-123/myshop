<?php

namespace App\Services;

use App\Interfaces\CartInterface;
use App\Interfaces\OrderInterface;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CartInterface $cart_interface,
        protected OrderInterface $order_interface
    ) {}


    public function OrderSummary(int $userId)
    {
        $cart = $this->cart_interface->getCart($userId);

        $summary = $this->order_interface->calculateSummary($cart);

        return [
            'cart' => $cart,
            'summary' => $summary,
        ];
    }
}
