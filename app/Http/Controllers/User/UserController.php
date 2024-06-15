<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Buisness\User\Entity\NullUserEntity;
use Illuminate\Support\Facades\Auth;
use Infrastructure\Interfaces\User\IUserRepository;
use Infrastructure\Repositories\UserRepository;

class UserController extends Controller
{
    public function show(int $id)
    {
        if($id !== Auth::user()->getAuthIdentifier()){
            return redirect('/');
        }
        /** @var UserRepository $rep */
        $rep = app(IUserRepository::class);
        $user = $rep->getById($id);
        if($user instanceof NullUserEntity){
            throw new \Exception('Что-то не так');
        }
        return view('user/show', ['user' => $user]);
    }

    public function edit(int $id)
    {
        if($id !== Auth::user()->getAuthIdentifier()){
            return redirect('/');
        }
        /** @var UserRepository $rep */
        $rep = app(IUserRepository::class);
        $user = $rep->getById($id);
        if($user instanceof NullUserEntity){
            throw new \Exception('Что-то не так');
        }
        return view('user/edit', ['user' => $user]);
    }
}
