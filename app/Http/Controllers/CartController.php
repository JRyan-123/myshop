<?php

namespace App\Http\Controllers;


use App\Http\Resources\CartResource;
use App\Repositories\CartInterfaceRepository;
use Inertia\Inertia;

class CartController extends Controller
{

    public function __construct(
        protected CartInterfaceRepository $cart_repository
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


}
