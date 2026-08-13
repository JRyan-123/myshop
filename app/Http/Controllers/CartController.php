<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Resources\CartResource;
use App\Repositories\CartInterfaceRepository;
use App\Services\CartService;
use Inertia\Inertia;

class CartController extends Controller
{

    public function __construct(
        protected CartInterfaceRepository $cart_repository,
        protected CartService $cart_service
    ){}


    /**
     * get users cart
     *
     * @return void
     */
    public function index()
    {
        $cart = $this->cart_repository->getCart(auth()->id());

        return Inertia::render('Cart/Index', [
            'cart' => CartResource::make($cart),
        ]);
    }

    /**
     * saving product to cart, cart item model
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
