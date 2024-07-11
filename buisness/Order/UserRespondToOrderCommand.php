<?php

declare(strict_types=1);

namespace Buisness\Order;

use App\Models\User\UserResponseOrder;
use Illuminate\Support\Facades\Log;
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
class UserRespondToOrderCommand extends BaseCommand
{
    private int $order_id;
    private int $user_id;

    public function execute(): JsonResponse
    {
        if (!(new CheckUserCanRespondToOrderCommand())
            ->setUserId($this->user_id)
            ->setOrderId($this->order_id)
            ->execute()) {
            return JsonFormatter::makeAnswer(Response::HTTP_NOT_ACCEPTABLE);
        }
        /** @var IOrderRepository $order_repository */
        $order_repository = app(IOrderRepository::class);
        $owner_id = $order_repository->getOrderOwnerId($this->order_id);

        $user_response_order_model = new UserResponseOrder();
        $user_response_order_model->user_id = $this->user_id;
        $user_response_order_model->order_id = $this->order_id;
        $user_response_order_model->owner_id = $owner_id;

        try {
            $user_response_order_model->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return JsonFormatter::makeAnswer(Response::HTTP_INTERNAL_SERVER_ERROR);
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
