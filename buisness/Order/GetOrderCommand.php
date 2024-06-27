<?php

declare(strict_types=1);

namespace Buisness\Order;

use Illuminate\Http\JsonResponse;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\Order\IOrderRepository;
use Infrastructure\Tools\JsonFormatter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class addOrderCommand
 * @package Buisness\Order
 * TODO: Сделать тест
 */
class GetOrderCommand extends BaseCommand
{
    private int $order_id;

    public function execute(): JsonResponse
    {
        /** @var IOrderRepository $order_repository */
        $order_repository = app(IOrderRepository::class);
        $order = $order_repository->getById($this->order_id);
        if(!$order){
            return JsonFormatter::makeAnswer(Response::HTTP_NOT_FOUND);
        }
        return JsonFormatter::makeAnswer(Response::HTTP_OK, json_encode($order));
    }

    public function setOrderId(int $order_id): self
    {
        $this->order_id = $order_id;
        return $this;
    }

}
