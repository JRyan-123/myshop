<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Interfaces\Admin\DashboardInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{

    public function __construct(
        protected DashboardInterface $dashboard_interface,
    ) {}


    public function index()
    {
        $orders = $this->dashboard_interface->getRecentOrders();

        return Inertia::render('Admin/Orders/Index', [
            'orders' => OrderResource::collection($orders)
        ]);
    }
}
