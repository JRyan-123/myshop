<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Interfaces\OrderInterface;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{

    public function __construct(
        protected OrderService $order_service,
        protected OrderInterface $order_interface,
    ) { }


    public function index()
    {
        $orders = $this->order_interface->getOrder(auth()->id());

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
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
