<?php

namespace App\Http\Controllers\Order\Api;

use App\Http\Controllers\Controller;
use Buisness\Order\GetOrderCommand;
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
            'category' => 'required|int|not_in:0',
        ]);
        $validator = \Infrastructure\Tools\Validator::validateData($validator);
        if ($validator) {
            return $validator;
        }

        try {
            return (new AddOrderCommand())
                ->setOrderVo(OrderVO::get(
                    ...request(['title', 'description'])
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
}
