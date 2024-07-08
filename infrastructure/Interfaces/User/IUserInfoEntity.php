<?php

declare(strict_types=1);

namespace Infrastructure\Interfaces\User;

/**
 * Class IUserInfoEntity
 * @package Infrastructure\Interfaces\User
 */
interface IUserInfoEntity
{
    public function getName(): string;

    public function getDescription(): string;

    public function getSecondName(): string;

    public function getId(): int;
    public function getAvatarId(): int;
}
