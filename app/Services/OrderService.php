<?php

namespace App\Services;

use App\Exceptions\EmptyCartException;
use App\Exceptions\InsufficientStockException;
use App\Interfaces\CartInterface;
use App\Interfaces\CheckoutInterface;
use App\Interfaces\OrderInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{

    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CheckoutService $checkout_service,
        protected PaymongoService $paymongo_service,

    ) {}




    /**
     * handles cart model to order model
     *
     * @param integer $userId
     * @param array $data
     * @return string
     */
    public function placeOrder(int $userId, array $data)
    {
        $order = $this->checkout_service->checkout($userId, $data);
    
        $session = $this->paymongo_service->createSession($order, $data['selectedPayment']);

        $this->paymongo_service->createPayment($order, $session);

        return $session;
    }



 
}
