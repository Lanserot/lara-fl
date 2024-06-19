<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SwaggerController extends Controller
{
    public function users(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('vendor/l5-swagger/index', [
            'documentation' => 'default',
            'urlToDocs' => url('/api/documentation/json'),
            'useAbsolutePath' => true
        ]);
    }
}
