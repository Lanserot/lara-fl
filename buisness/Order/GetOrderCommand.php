<?php

declare(strict_types=1);

namespace Buisness\Order;

use Illuminate\Http\JsonResponse;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\Order\IOrderRepository;
use Infrastructure\Tools\JsonFormatter;
use Symfony\Component\HttpFoundation\Response;

/**
 * @see \Tests\Unit\buisness\Order\Command\GetOrderCommandTest
 */
class GetOrderCommand extends BaseCommand
{
    private int $order_id;

    public function execute(): JsonResponse
    {
        /** @var IOrderRepository $order_repository */
        $order_repository = app(IOrderRepository::class);
        $order = $order_repository->getModelById($this->order_id);
        if(is_null($order)){
            return JsonFormatter::makeAnswer(Response::HTTP_NOT_FOUND);
        }
        return JsonFormatter::makeAnswer(Response::HTTP_OK, json_encode($order->toArray()));
    }

    public function setOrderId(int $order_id): self
    {
        $this->order_id = $order_id;
        return $this;
    }

}
