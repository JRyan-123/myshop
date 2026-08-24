<?php

namespace App\Interfaces\Admin;

interface DashboardInterface
{
    public function getMonthlySales($start, $end);

    public function getMonthlyOrders($start, $end);

    public function getListedBooks($start, $end);

    public function getUsers($start, $end);

    public function getRecentOrders();

    public function getLowStock();
}
