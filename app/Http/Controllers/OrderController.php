<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{

    public function __construct(
        protected OrderService $order_service,
    ) { }


    public function index()
    {

        return Inertia::render('Orders/Index');
    }

    public function store(CheckoutRequest $request)
    {
        $this->order_service->placeOrder(
            auth()->id(),
            $request->validated()
            );

        return redirect()->route('orders.index');

    }


}
