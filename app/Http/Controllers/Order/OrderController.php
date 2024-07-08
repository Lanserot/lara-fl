<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Models\Order\Order;
use Buisness\Order\CheckUserCanRespondToOrderCommand;
use Buisness\Order\GetOrderEntityCommand;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function list(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $orders = Order::query()
            ->select('orders.id', 'orders.title', 'orders.created_at')
            ->limit(10)
            ->get()
            ->toArray();

        return view('order.list', ['orders' => $orders]);
    }

    public function category(string $category): View|\Illuminate\Foundation\Application|Factory|Application
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
        return view("order/create", ['categories' => $categories]);
    }

    public function show(int $id): View|\Illuminate\Foundation\Application|Factory|Application|RedirectResponse
    {
        $order = (new GetOrderEntityCommand())->setOrderId($id)->execute();
        if ($order->getStatusCode() !== Response::HTTP_OK) {
            return redirect()->route('main');
        }

        $can_response = (new CheckUserCanRespondToOrderCommand())
            ->setOrderId($id)
            ->setUserId(auth()->user()?->getAuthIdentifier() ?? 0)
            ->execute();

        return view("order/show", [
            'order' => json_decode($order->getData()->message),
            'can_response' => $can_response->getStatusCode() == Response::HTTP_OK
        ]);
    }

    public function myList(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $orders = Order::query()
            ->select('orders.id', 'orders.title', 'orders.created_at')
            ->where('user_id', '=', auth()->user()->getAuthIdentifier())
            ->limit(10)
            ->get();

        return view('user.my_list', ['orders' => $orders]);
    }
}
