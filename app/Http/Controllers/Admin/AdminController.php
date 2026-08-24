<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OrderResource;
use App\Http\Resources\Admin\ProductResource;
use App\Interfaces\Admin\DashboardInterface;
use App\Services\Admin\DashboardService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{

    public function __construct(
        protected DashboardService $dashboard_service,
        protected DashboardInterface $dashboard_interface
    ){}


    public function index()
    {
        $orders = $this->dashboard_interface->getRecentOrders();
        $lowStock = $this->dashboard_interface->getLowStock();


        return Inertia::render('Admin/Dashboard',[
            'stats' => $this->dashboard_service->getResults(),
            'orders' => OrderResource::collection($orders),
            'lowStock' => ProductResource::collection($lowStock),
        ]);
    }
}
