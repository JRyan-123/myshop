<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function __construct(
        protected CheckoutService $checkout_service
    ) { }

    /**
     * cjeckout page with order summary and cart items
     *
     * @return void
     */
    public function index()
    {
        $data = $this->checkout_service->OrderSummary(auth()->id());

        $cart = $data['cart'];
        $summary = $data['summary'];

        return Inertia::render('Checkout/Index', [
            'cart' => $cart ? CartResource::make($cart) : null,
            'summary' => $summary
        ]);

    }
}
