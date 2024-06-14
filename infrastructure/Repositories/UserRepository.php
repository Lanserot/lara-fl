<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use App\Models\User;
use Buisness\User\Entity\UserEntity;
use Buisness\User\ValueObject\UserVO;
use Illuminate\Support\Facades\Hash;
use Infrastructure\Interfaces\User\IUserRepository;

class UserRepository implements IUserRepository
{
    public function getByLogin(UserVO $user_vo): UserVO
    {
         $user = User::query()
            ->where(User::FIELD_LOGIN, '=', $user_vo->getLogin())
            ->first();
        if (!$user || $user[UserVO::KEY_PASSWORD] != Hash::check($user_vo->getPassword(), $user->password)) {
            return UserVO::getNull();
        }
        $user = $user->toArray();
        return userVO::get(
            $user[userVO::KEY_LOGIN],
            $user[userVO::KEY_ID],
            $user[userVO::KEY_EMAIL],
            ''
        );
    }
    public function save(UserEntity $user): bool
    {
        try {
            User::create($user->toArray());
        }catch (\Exception $e){
            return false;
        }

        return true;
    }

}
