<?php

declare(strict_types=1);

namespace Buisness\User\Entity;

use Infrastructure\Interfaces\User\IUserEntity;

/**
 * Class UserEntity
 * @package Buisness\User\Entity
 */
final class NullUserEntity implements IUserEntity
{
    public function getLogin(): string
    {
        return '';
    }

    public function getEmail(): string
    {
        return '';
    }

    public function getId(): int
    {
        return 0;
    }

    public function getRoleId(): int
    {
        return 0;
    }
}
