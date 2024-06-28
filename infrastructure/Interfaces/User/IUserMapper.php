<?php

namespace Infrastructure\Interfaces\User;

use Buisness\User\ValueObject\UserVO;

interface IUserMapper
{
    public function entityToArray(IUserEntity $user): array;
    public function arrayLoginToVo(array $data): UserVO;
    public function arrayLoginToVoHash(array $data): UserVO;
    public function VoToArray(UserVO $user): array;

}
