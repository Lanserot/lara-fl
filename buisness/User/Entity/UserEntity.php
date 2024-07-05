<?php

declare(strict_types=1);

namespace Buisness\User\Entity;

use Infrastructure\Interfaces\User\IUserEntity;
use Infrastructure\Interfaces\User\IUserInfoEntity;

/**
 * Class UserEntity
 * @package Buisness\User\Entity
 */
final class UserEntity implements IUserEntity
{
    private string $login;
    private int $id;
    private int $role_id;
    private string $email;
    private IUserInfoEntity $user_info_entity;

    public function __construct(string $login, string $email, int $id, int $role_id, IUserInfoEntity $user_info_entity)
    {
        $this->login = $login;
        $this->email = $email;
        $this->id = $id;
        $this->role_id = $role_id;
        $this->user_info_entity = $user_info_entity;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function getUserInfoEntity(): IUserInfoEntity
    {
        return $this->user_info_entity;
    }
}
