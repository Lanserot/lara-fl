<?php

declare(strict_types=1);

namespace Infrastructure\Mapper\Order;

use App\Models\Order\Order;
use Buisness\Order\ValueObject\OrderVO;
use Infrastructure\Interfaces\Order\IOrderMapper;

/**
 * Class OrderMapper
 * @package Infrastructure\Mapper\Order
 */
class OrderMapper implements IOrderMapper
{
    public function VoToArray(OrderVO $orderVO): array
    {
        return [
            Order::FIELD_DESCRIPTION => $orderVO->getDescription(),
            Order::FIELD_TITLE => $orderVO->getTitle()
        ];
    }
}
