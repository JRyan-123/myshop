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
                        'line_items' => $order->orderItems->map(fn($item) => [

                            'name' => $item->product->name,
                            'amount' => $item->product->price * 100,
                            'currency' => 'PHP',
                            'quantity' => $item->quantity,
                            'images' => [
                                asset('storage/' . $item->product->image_path),
                            ],

                        ])->all(),
                        'reference_number' => $order->order_number,
                        'metadata' => [
                            'order_id' => $order->id,
                        ],
                        'payment_method_types' => [$paymentMethod],
                        'success_url' => route('checkout.success', [
                            'order' => $order->id,
                        ]),
                        'cancel_url' => route('checkout.cancel', [
                            'order' => $order->id,
                        ]),
                    ],
                ],
            ]);
        return $response->json('data');
    }

    public function createPayment(Order $order, array $session)
    {
        $order->payment()->create([
            'paymongo_checkout_session_id' => $session['id'],
            'paymongo_payment_id' => null,
            'status' => 'pending',
            'amount' => $order->total,
            'currency' => 'PHP',
            'payment_method_type' => $session['attributes']['payment_method_types'][0],
        ]);
    }
}
