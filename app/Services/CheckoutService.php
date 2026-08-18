<?php

namespace App\Services;

use App\Interfaces\CartInterface;
use App\Interfaces\CheckoutInterface;
use ErrorException;

class CheckoutService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CartInterface $cart_interface,
        protected CheckoutInterface $checkout_interface
    ) {}


    /**
     * Return order details
     *
     * @param integer $userId
     * @return void
     */
    public function OrderSummary(int $userId)
    {
        $cart = $this->cart_interface->getCart($userId);

        if (!$cart) {
           $summary = $this->noCart();
        }else {
            $summary = $this->checkout_interface->calculateSummary($cart);
        }

        return [
            'cart' => $cart,
            'summary' => $summary,
        ];
    }


    /**
     * Subtitute value if found no cart
     *
     * @return void
     */
    public function noCart()
    {
        return [
            'subtotal' => 0,
            'shipping_fee' => 0,
            'total' => 0,
        ];
    }
}
