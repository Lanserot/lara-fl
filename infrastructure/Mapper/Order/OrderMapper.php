<?php

declare(strict_types=1);

namespace Infrastructure\Mapper\Order;

use App\Models\Order\Order;
use Buisness\Order\ValueObject\OrderVO;
use Illuminate\Database\Eloquent\Model;
use Infrastructure\Interfaces\Order\IOrderMapper;

/**
 * Class OrderMapper
 * @package Infrastructure\Mapper\Order
 */
class OrderMapper implements IOrderMapper
{
    public function VoToArray(OrderVO $orderVo): array
    {
        return [
            Order::FIELD_DESCRIPTION => $orderVo->getDescription(),
            Order::FIELD_TITLE => $orderVo->getTitle(),
            Order::FIELD_DATE => $orderVo->getDate(),
            Order::FIELD_BUDGET => $orderVo->getBudget(),
        ];
    }

    public function ModelToVo(Model $order): OrderVO
    {
        return OrderVO::get(
            $order->title,
            $order->description,
            $order->created_at,
            $order->budget ?? 0,
            $order->date ?? '',
        );
    }
}
