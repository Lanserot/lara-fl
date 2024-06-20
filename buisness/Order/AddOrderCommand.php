<?php

declare(strict_types=1);

namespace Buisness\Order;

use App\Enums\HttpStatuses;
use Buisness\Order\Security\CanAddOrderCommand;
use Buisness\Order\ValueObject\OrderVO;
use Illuminate\Http\JsonResponse;
use Infrastructure\BaseCommand;
use Infrastructure\Tools\JsonFormatter;

/**
 * Class addOrderCommand
 * @package Buisness\Order
 */
class AddOrderCommand extends BaseCommand
{
    private OrderVO $order_vo;

    public function execute(): JsonResponse
    {
        if(!(new CanAddOrderCommand())->execute()){
            return JsonFormatter::makeAnswer((HttpStatuses::ACCESS_DENIED)->value);
        }

        return JsonFormatter::makeAnswer((HttpStatuses::UNKNOWN_ERROR)->value, (HttpStatuses::UNKNOWN_ERROR)->getDescription());
    }

    public function setOrderVo(OrderVO $order_vo): void
    {
        $this->order_vo = $order_vo;
    }
}
