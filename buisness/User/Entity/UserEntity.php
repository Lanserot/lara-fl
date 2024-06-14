<?php

declare(strict_types=1);

namespace Buisness\User\Entity;

use Infrastructure\Interfaces\User\IUserEntity;

/**
 * Class UserEntity
 * @package Buisness\User\Entity
 */
final class UserEntity implements IUserEntity
{
    private string $password;
    private string $login;
    private string $email;

    public function __construct(string $password, string $login, string $email)
    {
        $this->password = $password;
        $this->login = $login;
        $this->email = $email;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function toArray(): array
    {
        return [
            'password' => $this->password,
            'login' => $this->login,
            'email' => $this->email,
        ];
    }
}
