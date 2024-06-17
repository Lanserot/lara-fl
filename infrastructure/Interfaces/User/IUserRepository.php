<?php

namespace Infrastructure\Interfaces\User;

use Buisness\User\ValueObject\UserVO;

interface IUserRepository
{
    public function getByLogin(UserVO $user_vo): IUserEntity;
    public function save(UserVO $user): bool;
    public function getById(int $id): IUserEntity;
    public function update(array $user_update): bool;
    public function getUserInfoByUserId(int $id): IUserInfoEntity;
}
