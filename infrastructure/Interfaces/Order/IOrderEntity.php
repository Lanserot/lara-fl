<?php

namespace Infrastructure\Interfaces\Order;

use Buisness\Category\ValueObject\CategoryVO;
use Buisness\Order\ValueObject\OrderVO;

interface IOrderEntity
{
    public function getOrderVO(): OrderVO;
    public function getCategoryVO(): CategoryVO;
    public function getUserId(): int;
}
