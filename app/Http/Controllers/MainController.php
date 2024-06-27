<?php

namespace App\Http\Controllers;

use App\Models\Category\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {

        $categories = Category::query()->get();

        return view('welcome', ['categories' => $categories]);
    }
}
