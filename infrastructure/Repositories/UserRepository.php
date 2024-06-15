<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use App\Models\User;
use Buisness\User\Entity\UserEntity;
use Buisness\User\Entity\NullUserEntity;
use Buisness\User\ValueObject\UserVO;
use Illuminate\Support\Facades\Hash;
use Infrastructure\Interfaces\User\IUserEntity;
use Infrastructure\Interfaces\User\IUserRepository;

class UserRepository implements IUserRepository
{
    public function getByLogin(UserVO $user_vo): IUserEntity
    {
         $user = User::query()
            ->where(User::FIELD_LOGIN, '=', $user_vo->getLogin())
            ->first();
        if (!$user || $user[UserVO::KEY_PASSWORD] != Hash::check($user_vo->getPassword(), $user->password)) {
            return new NullUserEntity();
        }
        $user = $user->toArray();
        return new UserEntity(
            $user[userVO::KEY_LOGIN],
            $user[userVO::KEY_EMAIL],
            $user[userVO::KEY_ID],
        );
    }

    public function save(UserVO $user): bool
    {
        try {
            User::create($user->toArray());
        }catch (\Exception $e){
            return false;
        }

        return true;
    }

    public function getById(int $id): IUserEntity
    {
        $user = User::query()
            ->where(User::FIELD_ID, '=', $id)
            ->first();
        if(!$user){
            return new NullUserEntity();
        }
        return new UserEntity(
            $user->login,
            $user->email,
            $user->id,
        );
    }
}
