<?php

namespace App\Http\Controllers\Order\Api;

use App\Http\Controllers\Controller;
use App\Rules\DateFormat;
use Buisness\Order\CheckUserCanRespondToOrderCommand;
use Buisness\Order\GetOrderCommand;
use Buisness\Order\UserRespondToOrderCommand;
use Symfony\Component\HttpFoundation\Response;
use Buisness\Order\AddOrderCommand;
use Buisness\Order\ValueObject\OrderVO;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required|max:50',
            'description' => 'required',
            'budget' => 'required|int',
            'date' => ['nullable', new DateFormat()],
        ]);
        $validator = \Infrastructure\Tools\Validator::validateData($validator);
        if ($validator) {
            return $validator;
        }

        try {
            return (new AddOrderCommand())
                ->setOrderVo(OrderVO::get(
                    $request->get('title'),
                    $request->get('description'),
                    '',
                    $request->get('budget'),
                    $request->get('date'),
                ))
                ->setCategoryId($request->get('category'))
                ->execute();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id): JsonResponse
    {
        return (new GetOrderCommand())->setOrderId($id)->execute();
    }

    public function canResponse(Request $request): JsonResponse
    {
        return (new CheckUserCanRespondToOrderCommand())
            ->setUserId((int) $request->get('user_id'))
            ->setOrderId((int) $request->get('order_id'))
            ->execute();
    }
}
