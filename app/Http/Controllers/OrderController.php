<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
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
    ) {}



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
     * @return string
     */
    public function store(CheckoutRequest $request)
    {
        $session = $this->order_service->placeOrder(
            auth()->id(),
            $request->validated()
        );
        $checkoutUrl = $session['attributes']['checkout_url'];

        return Inertia::location($checkoutUrl);
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

    private function findUserOrder(Request $request)
    {
        return Order::with(['orderItems.product', 'payment'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($request->query('order'));
    }

    public function success(Request $request)
    {
        return Inertia::render('Checkout/SuccessPage',[
            'order' => $this->findUserOrder($request)
        ]);
    }

    public function cancel(Request $request)
    {
        return Inertia::render('Checkout/CancelPage',[
            'order' => $this->findUserOrder($request)
        ]);
    }

    public function retryPayment(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403, 'Unauthorized');
        
        $session = $this->order_service->retryPayment($order);

        return Inertia::location($session['attributes']['checkout_url']);
    }

    public function cancelOrder(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403, 'Unauthorized');

        if ($order->status !== OrderStatus::Pending) {
            return redirect()->back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update(['status' => OrderStatus::Cancelled]);
        $order->payment()->update(['status' => PaymentStatus::Failed]);

        return redirect()->route('orders.index')->with('success', 'Order has been cancelled successfully.');
    }

}
