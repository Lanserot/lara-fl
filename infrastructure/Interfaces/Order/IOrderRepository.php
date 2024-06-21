<?php

namespace Infrastructure\Interfaces\Order;

use Buisness\Order\ValueObject\OrderVO;

interface IOrderRepository
{
    public function save(OrderVO $order_vo): bool;
}
