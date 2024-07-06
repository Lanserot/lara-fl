<?php

declare(strict_types=1);

namespace Buisness\Order;

use Buisness\Order\Entity\NullOrderEntity;
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
class GetOrderEntityCommand extends BaseCommand
{
    private int $order_id;

    public function execute(): JsonResponse
    {
        /** @var IOrderRepository $order_repository */
        $order_repository = app(IOrderRepository::class);
        $order = $order_repository->getEntityById($this->order_id);
        if($order instanceof NullOrderEntity){
            return JsonFormatter::makeAnswer(Response::HTTP_NOT_FOUND);
        }
        return JsonFormatter::makeAnswer(Response::HTTP_OK, json_encode([
            'order' => $order->getOrderVO()->toArray(),
            'category' => $order->getCategoryVO()->toArray(),
        ]));
    }

    public function setOrderId(int $order_id): self
    {
        $this->order_id = $order_id;
        return $this;
    }

}
