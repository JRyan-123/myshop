<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Exceptions\EmptyCartException;
use App\Exceptions\InsufficientStockException;
use App\Interfaces\CartInterface;
use App\Interfaces\CheckoutInterface;
use App\Interfaces\OrderInterface;
use App\Models\Order;
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


    public function retryPayment(Order $order)
    {
        return DB::transaction(function () use ($order) {

            $order = Order::with('payment')->lockForUpdate()->findOrFail($order->id);

            if ($order->status !== OrderStatus::Pending) {
                throw new \Exception('Payment can only be retried for pending orders.');
            }

            $payment = $order->payment;

            if (!$payment || $payment->status === OrderStatus::Paid) {
                throw new \Exception('Payment cannot be retried for this order.');
            }

            $session = $this->paymongo_service->createSession($order, $payment->payment_method_type);
            
            $payment->update([
                'paymongo_checkout_session_id' => $session['id'],
                'status' => PaymentStatus::Pending,
            ]);

            return $session;
        });
    }
}
