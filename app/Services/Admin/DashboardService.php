<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\DashboardInterface;

use function Illuminate\Support\now;

class DashboardService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected DashboardInterface $dashboard_interface,
    ) {}



    /**
     * calculate current and previous month and get change percentage
     *
     * @return void
     */
    public function getResults()
    {
        $currentStart = now()->startOfMonth();
        $currentEnd = now()->endOfMonth();

        $prevStart = now()->subMonth()->startOfMonth();
        $prevEnd = now()->subMonth()->endOfMonth();


        // sales
        $sales = $this->dashboard_interface->getMonthlySales(
            $currentStart,
            $currentEnd
        );

        $prevSales = $this->dashboard_interface->getMonthlySales(
            $prevStart,
            $prevEnd
        );



        // orders
        $orders = $this->dashboard_interface->getMonthlyOrders(
            $currentStart,
            $currentEnd
        );

        $prevOrders = $this->dashboard_interface->getMonthlyOrders(
            $prevStart,
            $prevEnd
        );



        // books
        $books = $this->dashboard_interface->getListedBooks(
            $currentStart,
            $currentEnd
        );

        $prevBooks = $this->dashboard_interface->getListedBooks(
            $prevStart,
            $prevEnd
        );



        // user
        $users = $this->dashboard_interface->getUsers(
            $currentStart,
            $currentEnd
        );

        $prevUsers = $this->dashboard_interface->getUsers(
            $prevStart,
            $prevEnd
        );

        return [
            'sales' => [
                'value' => $sales,
                'comparison' => $this->getComparison($sales, $prevSales)
            ],
            'orders' => [
                'value' => $orders,
                'comparison' => $this->getComparison($orders, $prevOrders)
            ],
            'books' => [
                'value' => $books,
                'comparison' => $this->getComparison($books, $prevBooks)
            ],
            'users' => [
                'value' => $users,
                'comparison' => $this->getComparison($users, $prevUsers)
            ]
        ];
    }



    /**
     * handles change comparison
     *
     * @param [type] $current
     * @param [type] $prev
     * @return void
     */
    public function getComparison($current, $prev)
    {
        if ($prev === 0) {
            return 0;
        }

        return round((($current - $prev) / $prev) * 100, 2);
    }
}
