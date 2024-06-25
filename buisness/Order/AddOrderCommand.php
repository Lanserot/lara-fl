<?php

declare(strict_types=1);

namespace Buisness\Order;

use Buisness\File\Security\CanAddFileCommand;
use Buisness\Order\ValueObject\OrderVO;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\Order\IOrderRepository;
use Infrastructure\Repositories\OrderRepository;
use Infrastructure\Tools\JsonFormatter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class addOrderCommand
 * @package Buisness\Order
 */
class AddOrderCommand extends BaseCommand
{
    private OrderVO $order_vo;

    public function execute(): JsonResponse
    {
        if (!(new CanAddFileCommand())->execute()) {
            return JsonFormatter::makeAnswer(Response::HTTP_FORBIDDEN);
        }

        if (!DB::table('categories')->where('id', '=', $this->order_vo->getCategoryId())->exists()) {
            return JsonFormatter::makeAnswer(Response::HTTP_NOT_FOUND);
        }

        /** @var OrderRepository $order_repository */
        $order_repository = app(IOrderRepository::class);
        $result = $order_repository->save($this->order_vo);
        if ($result) {
            return JsonFormatter::makeAnswer(Response::HTTP_OK);
        }
        return JsonFormatter::makeAnswer(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function setOrderVo(OrderVO $order_vo): void
    {
        $this->order_vo = $order_vo;
    }
}
