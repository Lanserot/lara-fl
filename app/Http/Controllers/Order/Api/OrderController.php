<?php

namespace App\Http\Controllers\Order\Api;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Enums\HttpStatuses;

class OrderController extends Controller{

 public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required|max:50',
            'description' => 'required|max:500',
            'user_id' => 'required|max:50'
        ]);
        $validator = \Infrastructure\Tools\Validator::validateData($validator);
        if($validator){
            return $validator;
        }
        try {
            Order::created($data);
        } catch (Exception $e) {
            return response()->json(['message' =>$e->getMessage()])->setStatusCode((HttpStatuses::ERROR)->value);
        }
        return response()->json()->setStatusCode((HttpStatuses::SUCCESS)->value);
    }
}
