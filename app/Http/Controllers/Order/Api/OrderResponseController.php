<?php

declare(strict_types=1);

namespace App\Http\Controllers\Order\Api;

use Buisness\Order\UserRespondToOrderCommand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class OrderResponseController
 * @package App\Http\Controllers\Order\Api
 */
class OrderResponseController
{
    public function store(Request $request): JsonResponse
    {
        //TODO: swagger
        return (new UserRespondToOrderCommand())
            ->setOrderId((int) $request->get('order_id'))
            ->setUserId((int) $request->get('user_id'))
            ->execute();
    }
}
