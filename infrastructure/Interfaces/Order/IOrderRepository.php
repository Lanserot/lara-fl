<?php

namespace Infrastructure\Interfaces\Order;

use Buisness\Order\ValueObject\OrderVO;
use Illuminate\Database\Eloquent\Model;

interface IOrderRepository
{
    public function save(OrderVO $order_vo): bool;
    public function getEntityById(int $id): IOrderEntity;
    public function getModelById(int $id): ?Model;
    public function getOrderOwnerId(int $id): ?int;
}
