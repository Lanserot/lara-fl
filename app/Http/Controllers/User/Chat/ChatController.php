<?php

namespace App\Http\Controllers\User\Chat;

use App\Http\Controllers\Controller;
use App\Models\User\UserResponseOrder;

class ChatController extends Controller
{
    public function index()
    {
        //TODO: в комманду
        // $response = UserResponseOrder::query()
        //     ->where('owner_id', auth()->user()->getAuthIdentifier())
        //     ->get();
        // отклик - ордер
        $owner_id = auth()->user()->getAuthIdentifier();
        $response = UserResponseOrder::where("owner_id", $owner_id)->get();



        return view('user/chat/index', ['responses' => $response]);
    }
}
