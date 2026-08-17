<?php

namespace App\Services;

use App\Interfaces\CartInterface;
use App\Interfaces\CheckoutInterface;


class CheckoutService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CartInterface $cart_interface,
        protected CheckoutInterface $order_interface
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
