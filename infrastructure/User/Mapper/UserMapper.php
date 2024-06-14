<?php

declare(strict_types=1);

namespace Infrastructure\User\Mapper;

use Buisness\User\ValueObject\UserVO;

/**
 * Class UserMapper
 * @package Infrastructure\User\Mapper
 */
class UserMapper
{
    public function arrayLoginToVo(array $data): UserVO
    {
        return UserVO::get(
            $data[UserVO::KEY_LOGIN] ?? '',
            (int)$data[UserVO::KEY_PASSWORD] ?? 0,
            $data[UserVO::KEY_EMAIL] ?? '',
            $data[UserVO::KEY_PASSWORD] ?? '',
        );
    }
}
