<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Resources\CartResource;
use App\Interfaces\CartInterface;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\OrderService;
use Inertia\Inertia;

class CartController extends Controller
{

    public function __construct(
        protected CartService $cart_service,
        protected CheckoutService $checkout_service
    ){}


    /**
     * get users cart
     *
     * @return void
     */
    public function index()
    {
        $data = $this->checkout_service->OrderSummary(auth()->id());

        $cart = $data['cart'];
        $summary = $data['summary'];

        return Inertia::render('Cart/Index', [
            'cart' => $cart ? CartResource::make($cart) : null,
            'summary' => $summary
        ]);
    }

    /**
     * saving product to cart and cart item model
     *
     * @param AddToCartRequest $request
     * @return void
     */
    public function store(AddToCartRequest $request)
    {
        $this->cart_service->addToCart(
            auth()->id(),
            $request->product_id
        );

        return back()->with('success', 'Added to cart.');
    }

}
