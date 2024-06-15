<?php

declare(strict_types=1);

namespace Infrastructure\Mapper\User;

use Buisness\User\ValueObject\UserVO;
use Illuminate\Support\Facades\Hash;
use Infrastructure\Interfaces\IUserMapper;
use Infrastructure\Interfaces\User\IUserEntity;

/**
 * Class UserMapper
 * @package Infrastructure\Mapper\User
 */
class UserMapper implements IUserMapper
{
    public function entityToArray(IUserEntity $user): array
    {
        return [
            'id' => $user->getId(),
            'login' => $user->getLogin(),
            'email' => $user->getEmail(),
        ];
    }

    public function arrayLoginToVo(array $data): UserVO
    {
        return UserVO::get(
            $data[UserVO::KEY_LOGIN] ?? '',
            (int)$data[UserVO::KEY_PASSWORD] ?? 0,
            $data[UserVO::KEY_EMAIL] ?? '',
            $data[UserVO::KEY_PASSWORD] ?? '',
        );
    }

    public function arrayLoginToVoHash(array $data): UserVO
    {
        return UserVO::get(
            $data[UserVO::KEY_LOGIN] ?? '',
            (int)$data[UserVO::KEY_PASSWORD] ?? 0,
            $data[UserVO::KEY_EMAIL] ?? '',
            Hash::make($data[UserVO::KEY_PASSWORD]) ?? '',
        );
    }
}
