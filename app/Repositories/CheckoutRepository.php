<?php

namespace App\Repositories;

use App\Interfaces\CheckoutInterface;


class CheckoutRepository implements CheckoutInterface
{
    public function calculateSummary($cart)
    {
        $subtotal = $cart->cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingFee = 25 + ($cart->cartItems->count() * 5);

        $total = $subtotal + $shippingFee;

        return [
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'total' => $total,
        ];
    }
}
