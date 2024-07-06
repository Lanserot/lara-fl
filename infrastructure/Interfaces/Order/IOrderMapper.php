<?php

namespace Infrastructure\Interfaces\Order;

use Buisness\Order\ValueObject\OrderVO;
use Illuminate\Database\Eloquent\Model;

interface IOrderMapper
{
    public function VoToArray(OrderVO $orderVo): array;
    public function ModelToVo(Model $orderVo): OrderVO;
}
