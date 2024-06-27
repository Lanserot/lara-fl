<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Models\Order\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    public function list()
    {
        //TODO: вынести в комманду
        $orders = Order::query()
            ->select('orders.id', 'orders.title', 'orders.created_at')
            ->limit(10)
            ->get()
            ->toArray();

        return view('order.list', ['orders' => $orders]);
    }

    public function category(string $category)
    {
        //TODO: вынести в комманду
        $orders_ids = Category::query()
            ->select('order_to_category.order_id')
            ->join('order_to_category', 'order_to_category.category_id', '=', 'categories.id')
            ->where('name', '=', $category)
            ->limit(10)
            ->pluck('order_id')
            ->toArray();
        $orders = Order::query()->whereIn('id', $orders_ids)->get()->toArray();
        return view('order.list', ['orders' => $orders]);
    }

    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $categories = Category::all();
        return view("order/order", ['categories' => $categories]);
    }
}
