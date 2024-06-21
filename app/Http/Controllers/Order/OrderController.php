<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $categories = Category::all();
        return view("order/order", ['categories' => $categories]);
    }
}
