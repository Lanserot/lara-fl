<?php

namespace Infrastructure\Interfaces\User;

use Buisness\User\ValueObject\UserVO;

interface IUserRepository
{
    public function getByLogin(UserVO $user_vo): UserVO;

}
