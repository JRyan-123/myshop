<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function __construct(
        protected OrderService $order_service
    ) { }

    public function index()
    {
        $data = $this->order_service->OrderSummary(auth()->id());

        $cart = $data['cart'];
        $summary = $data['summary'];

        return Inertia::render('Checkout/Index', [
            'cart' => $cart ? CartResource::make($cart) : null,
            'summary' => $summary
        ]);

    }
}
