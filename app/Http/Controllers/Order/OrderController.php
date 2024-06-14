<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
return view("order/order");
    }
public function post(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|max:50',
        'description' => 'required|max:500',
        'user_id' => 'required|max:50'
    ]);

    // Сохранение данных в базе данных
    Order::create($validatedData); 
}
}
