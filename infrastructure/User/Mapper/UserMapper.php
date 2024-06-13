<?php

declare(strict_types=1);

namespace Infrastructure\User\Mapper;

use Buisness\User\ValueObject\UserLoginVO;

/**
 * Class UserMapper
 * @package Infrastructure\User\Mapper
 */
class UserMapper
{
    public function arrayLoginToVo(array $data): UserLoginVO
    {
        return UserLoginVO::get(
            $data[UserLoginVO::KEY_LOGIN] ?? '',
            $data[UserLoginVO::KEY_PASSWORD] ?? ''
        );
    }
}
