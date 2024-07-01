<?php

declare(strict_types=1);

namespace Buisness\UserInfo\Entity;

use Infrastructure\Interfaces\User\IUserInfoEntity;

/**
 * Class UserEntity
 * @package Buisness\User\Entity
 */
final class NullUserInfoEntity implements IUserInfoEntity
{
    public function getName(): string
    {
        return '';
    }

    public function getDescription(): string
    {
        return '';
    }

    public function getSecondName(): string
    {
        return '';
    }

    public function getId(): int
    {
        return 0;
    }
}
