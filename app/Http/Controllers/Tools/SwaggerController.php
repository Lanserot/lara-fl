<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class SwaggerController extends Controller
{
    public function users(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('vendor/l5-swagger/users', [
            'documentation' => 'default',
            'urlToDocs' => url('/api/documentation/json/users'),
            'useAbsolutePath' => true
        ]);


    }

    public function orders(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('vendor/l5-swagger/orders', [
            'documentation' => 'default',
            'urlToDocs' => url('/api/documentation/json/orders'),
            'useAbsolutePath' => true
        ]);

    }
}
