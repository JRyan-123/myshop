<?php

namespace App\Repositories\Admin;

use App\Enums\OrderStatus;
use App\Interfaces\Admin\DashboardInterface;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Override;

class DashboardRepository implements DashboardInterface
{

    public function getMonthlySales($start, $end)
    {
        return Order::where('status', OrderStatus::Completed)
            ->whereBetween('created_at', [$start, $end])
            ->sum('total');
    }


    public function getMonthlyOrders($start, $end)
    {
        return Order::whereBetween('created_at', [$start, $end])
            ->count();
    }

    public function getListedBooks($start, $end)
    {
        return Product::whereBetween('created_at', [$start, $end])
            ->count();
    }


    public function getUsers($start, $end)
    {
        return User::whereBetween('created_at', [$start, $end])
            ->count();
    }



    public function getRecentOrders()
    {
         return Order::latest()
            ->limit(10)->get();
    }


    public function getLowStock()
    {
        return Product::where('stock', '<=', 5)
            ->orderBy('stock')
            ->limit(10)
            ->get();
    }

}
