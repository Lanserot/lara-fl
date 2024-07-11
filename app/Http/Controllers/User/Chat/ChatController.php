<?php

namespace App\Http\Controllers\User\Chat;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Models\User\User;
use App\Models\User\UserInfo;
use App\Models\User\UserResponseOrder;

class ChatController extends Controller
{
    public function index()
    {
        //TODO: в комманду
        $response = UserResponseOrder::query()
            ->whereIn('owner_id', auth()->user()->getAuthIdentifier())
            ->get();
        // отклик - ордер


        return view('user/chat/index', ['users' => $users, 'orders' => $orders]);
    }
}
