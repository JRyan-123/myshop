<?php

namespace App\Interfaces;

use App\Models\Order;

interface OrderInterface
{
    public function createOrder(array $data);

    public function createOrderItem(Order $order, array $data);

    public function getOrder(int $userId);

}
