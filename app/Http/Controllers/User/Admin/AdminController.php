<?php

namespace App\Http\Controllers\User\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('user/admin/index');
    }
}
