<?php

namespace Infrastructure\Interfaces\User;

use Buisness\User\ValueObject\UserVO;
use Illuminate\Database\Eloquent\Model;

interface IUserRepository
{
    public function getByLogin(UserVO $user_vo): IUserEntity;
    public function save(UserVO $user): bool;
    public function getEntityById(int $id): IUserEntity;
    public function update(Model $user_update): bool;
    public function getUserInfoByIdEntity(int $id): IUserInfoEntity;
    public function getModelById(int $id): ?Model;

    public function isExistFieldValue(string $field, mixed $value): bool;
}
