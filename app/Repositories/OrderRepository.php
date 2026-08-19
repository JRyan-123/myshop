<?php

namespace App\Repositories;

use App\Interfaces\OrderInterface;
use App\Models\Order;
use Override;

class OrderRepository implements OrderInterface
{

    /**
     * save order
     *
     * @param array $data
     * @return void
     */
    public function createOrder(array $data)
    {
        return Order::create($data);
    }


    /**
     * save order items
     *
     * @param Order $order
     * @param array $data
     * @return void
     */
    public function createOrderItem(Order $order, array $data)
    {
        return $order->orderItems()->create($data);
    }
}
