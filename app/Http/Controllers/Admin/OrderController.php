<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Interfaces\Admin\DashboardInterface;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{

    public function __construct(
        protected DashboardInterface $dashboard_interface,
    ) {}


    public function index(Request $request)
    {

        $orders = Order::with('orderItems.product')
            ->search($request->search)
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Orders/Index', [
            'orders' => OrderResource::collection($orders),
            'filters' => $request->only([
                'search',
            ])
        ]);
    }
}
