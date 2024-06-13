<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use App\Models\User;
use Buisness\User\ValueObject\UserVO;

class UserRepository
{
    public function getByLogin(string $login, string $password): UserVO
    {
        $user = User::query()
            ->where(User::FIELD_LOGIN, '=', $login)
            ->where(User::FIELD_PASSWORD, '=', md5($password), 'and')
            ->first();
        if (!$user) {
            return UserVO::getNull();
        }
        return userVO::get(
            $user[userVO::KEY_LOGIN],
            $user[userVO::KEY_ID]
        );
    }
}
