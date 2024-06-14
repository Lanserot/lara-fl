<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('user/registration');
    }
}
