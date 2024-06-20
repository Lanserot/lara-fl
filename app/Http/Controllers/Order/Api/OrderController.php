<?php

namespace App\Http\Controllers\Order\Api;

use App\Http\Controllers\Controller;
use Buisness\Order\AddOrderCommand;
use Buisness\Order\ValueObject\OrderVO;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Enums\HttpStatuses;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required|max:50',
            'description' => 'required|max:500',
            'user_id' => 'required|max:50'
        ]);
        $validator = \Infrastructure\Tools\Validator::validateData($validator);
        if ($validator) {
            return $validator;
        }

        try {
            $command = new AddOrderCommand();
            $command->setOrderVo(OrderVO::get(
                ...request(['title', 'description'])
            ));
            return $command->execute();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()])->setStatusCode((HttpStatuses::ERROR)->value);
        }
    }
}
