<?php

namespace Infrastructure\Interfaces\Order;

use Buisness\Order\ValueObject\OrderVO;

interface IOrderMapper
{
    public function VoToArray(OrderVO $orderVo): array;
}
