<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FileStorage;
use Buisness\User\Entity\NullUserEntity;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Repositories\UserRepository;

class UserController extends Controller
{
    public function show(int $id): \Illuminate\Foundation\Application|View|Factory|Redirector|Application|RedirectResponse
    {
        if($id !== Auth::user()->getAuthIdentifier()){
            return redirect('/');
        }
        /** @var UserRepository $rep */
        $rep = app(IUserRepository::class);
        $user = $rep->getEntityById($id);
        if($user instanceof NullUserEntity){
            throw new Exception('Что-то не так');
        }
        $user_info = $rep->getUserInfoByUserId($user->getId());
        $file_path = FileStorage::query()
            ->where(FileStorage::FIELD_GROUP, '=', 1)
            ->where(FileStorage::FIELD_USER_ID, '=', $id)
            ->first();
        return view('user/show', ['user' => $user, 'user_info' => $user_info, 'file_path' => $file_path]);
    }

    public function edit(int $id): \Illuminate\Foundation\Application|View|Factory|Redirector|Application|RedirectResponse
    {
        if($id !== Auth::user()->getAuthIdentifier()){
            return redirect('/');
        }
        /** @var UserRepository $rep */
        $rep = app(IUserRepository::class);
        $user = $rep->getEntityById($id);
        if($user instanceof NullUserEntity){
            throw new Exception('Что-то не так');
        }
        $user_info = $rep->getUserInfoByUserId($user->getId());
        return view('user/edit', ['user' => $user, 'user_info' => $user_info]);
    }
}
