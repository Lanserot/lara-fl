<?php

declare(strict_types=1);

namespace Buisness\Order;

use App\Models\User\UserResponseOrder;
use Infrastructure\BaseCommand;
use Infrastructure\Interfaces\Order\IOrderRepository;
use Infrastructure\Tools\JsonFormatter;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CheckUserCanRespondToOrderCommand
 * @package Buisness\Order
 * TODO: test
 */
class CheckUserCanRespondToOrderCommand extends BaseCommand
{
    private int $order_id;
    private int $user_id;

    public function execute(): JsonResponse
    {
        /** @var IOrderRepository $order_repository */
        $order_repository = app(IOrderRepository::class);
        $owner_id = $order_repository->getOrderOwnerId($this->order_id);

        if (is_null($owner_id)) {
            return JsonFormatter::makeAnswer(Response::HTTP_NOT_FOUND);
        }
        if ($owner_id == $this->user_id) {
            return JsonFormatter::makeAnswer(Response::HTTP_ACCEPTED);
        }
        if (UserResponseOrder::query()
            ->where([
                ['user_id', '=', $this->user_id],
                ['order_id', '=', $this->order_id]
            ])
            ->exists()) {
            return JsonFormatter::makeAnswer(Response::HTTP_FOUND);
        }
        return JsonFormatter::makeAnswer(Response::HTTP_OK);

    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function setOrderId(int $order_id): self
    {
        $this->order_id = $order_id;
        return $this;
    }
}
