<?php

namespace App\Interfaces;

interface CheckoutInterface
{
    public function calculateSummary($cart);
}
