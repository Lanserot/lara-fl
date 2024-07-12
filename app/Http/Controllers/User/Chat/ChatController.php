<?php

namespace App\Http\Controllers\User\Chat;

use App\Http\Controllers\Controller;
use App\Models\User\UserResponseOrder;

class ChatController extends Controller
{
    public function index()
    {
        $response = UserResponseOrder::where("owner_id", auth()->user()->getAuthIdentifier())->get();
        return view('user/chat/index', ['responses' => $response]);
    }
}
