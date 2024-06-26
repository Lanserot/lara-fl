<?php

declare(strict_types=1);

namespace Infrastructure\Mapper\User;

use Buisness\User\ValueObject\UserVO;
use Illuminate\Support\Facades\Hash;
use Infrastructure\Interfaces\User\IUserEntity;
use Infrastructure\Interfaces\User\IUserMapper;

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
            'password' => '',
            'role_id' => $user->getRoleId(),
        ];
    }

    public function arrayLoginToVo(array $data): UserVO
    {
        return UserVO::get(
            $data[UserVO::KEY_LOGIN] ?? '',
            (int)$data[UserVO::KEY_PASSWORD] ?? 0,
            $data[UserVO::KEY_EMAIL] ?? '',
            $data[UserVO::KEY_PASSWORD] ?? '',
            $data[UserVO::KEY_ROLE_ID] ?? 0,
        );
    }

    public function arrayLoginToVoHash(array $data): UserVO
    {
        return UserVO::get(
            $data[UserVO::KEY_LOGIN] ?? '',
            (int)$data[UserVO::KEY_PASSWORD] ?? 0,
            $data[UserVO::KEY_EMAIL] ?? '',
            Hash::make($data[UserVO::KEY_PASSWORD]) ?? '',
            $data[UserVO::KEY_ROLE_ID] ?? 0,
        );
    }

    public function VoToArray(UserVO $user): array
    {
        return [
            UserVO::KEY_LOGIN => $user->getLogin(),
            UserVO::KEY_PASSWORD => $user->getPassword(),
            UserVO::KEY_ID => $user->getId(),
            UserVO::KEY_ROLE_ID => $user->getRoleId(),
            UserVO::KEY_EMAIL => $user->getEmail()
        ];
    }

}
