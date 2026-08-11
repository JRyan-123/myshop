<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Repositories\CartInterfaceRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{

    public function __construct(
        protected CartInterfaceRepository $cart_repository
    ){}


    public function index()
    {
        $cart = $this->cart_repository->getCart(auth()->id());

        return Inertia::render('Cart/Index', [
            'cart' => CartResource::make($cart),
        ]);


    }
}
