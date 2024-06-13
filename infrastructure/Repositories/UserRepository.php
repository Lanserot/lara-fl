<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use App\Models\User;
use Buisness\User\UserVO;

class UserRepository
{
    public function getByLogin(string $login): UserVO
    {
        $user = User::query()->where(User::FIELD_LOGIN, '=', $login)->first();
        if (!$user) {
            return UserVO::getNull();
        }
        return userVO::get($user[userVO::KEY_LOGIN], $user[userVO::KEY_ID]);
    }
}
