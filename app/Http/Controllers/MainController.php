<?php

namespace App\Http\Controllers;

use App\Models\Category\Category;
use App\Models\FileStorage;
use App\Models\User\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $categories = Category::query()->get();
        $users = User::query()
            ->select(FileStorage::TABLE . '.' . FileStorage::FIELD_NAME .' as file_name', 'users_info.name', FileStorage::TABLE . '.' . FileStorage::FIELD_PATH, 'users.id')
            ->leftJoin('users_info', 'users.id', '=', 'users_info.user_id')
            ->leftJoin(FileStorage::TABLE, 'users_info.avatar_id', '=', FileStorage::TABLE . '.id')
            ->limit(12)
            ->orderBy('users.id')
            ->get();
        return view('welcome', ['categories' => $categories, 'users' => $users]);
    }
}
