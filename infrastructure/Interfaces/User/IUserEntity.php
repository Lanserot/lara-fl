<?php

declare(strict_types=1);

namespace Infrastructure\Interfaces\User;

/**
 * Class IUserEntity
 * @package Infrastructure\Interfaces\User
 */
interface IUserEntity
{
    public function getLogin(): string;

    public function getPassword(): string;

    public function getEmail(): string;
}
