<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class PaymongoService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createSession(Order $order, string $paymentMethod)
    {
        $response = Http::withBasicAuth(config('services.paymongo.secret_key'), '')
            ->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        'line_items' => $order->orderItems->map(fn ($item) => [ 
                            
                                'name' => $item->product->name,
                                'amount' => $item->product->price * 100, 
                                'currency' => 'PHP',
                                'quantity' => $item->quantity,
                            
                        ])->all(),
                        'reference_number' => $order->order_number,
                        'metadata' => [
                            'order_id' => $order->id,
                        ],
                        'payment_method_types' => [$paymentMethod],
                        'success_url' => route('checkout.success'),
                        'cancel_url' => route('checkout.cancel'),
                    ],
                ],
            ]);
        return $response->json('data');
    }
}
