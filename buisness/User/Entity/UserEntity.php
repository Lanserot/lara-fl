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
    private string $login;
    private int $id;
    private string $email;

    public function __construct(string $login, string $email, int $id)
    {
        $this->login = $login;
        $this->email = $email;
        $this->id = $id;
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
}
