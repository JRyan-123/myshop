<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\OrderResource;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{

    public function __construct(
        protected OrderService $order_service,
        protected OrderInterface $order_interface,
    ) { }



    /**
     * order history currnet and old
     *
     * @return void
     */
    public function index()
    {
        $orders = $this->order_interface->getOrder(auth()->id());

        return Inertia::render('Orders/Index', [
            'orders' => OrderResource::collection($orders),
        ]);
    }



    /**
     * save orders
     *
     * @param CheckoutRequest $request
     * @return void
     */
    public function store(CheckoutRequest $request)
    {
        $this->order_service->placeOrder(
            auth()->id(),
            $request->validated()
            );

        return redirect()->route('orders.index');

    }


    /**
     * display chosen order
     *
     * @param Order $order
     * @return void
     */
    public function show(Order $order)
    {
        $order->load('orderItems.product');

        return Inertia::render('Orders/Show', [
            'order' => OrderResource::make($order),
            'statuses' => collect(OrderStatus::cases())
                ->map(fn($status) => [
                    'value' => $status->value,
                    'label' => $status->label()
                ])->values(),
        ]);
    }


}
