<?php

declare(strict_types=1);

namespace Buisness\UserInfo\Entity;

use Infrastructure\Interfaces\User\IUserInfoEntity;

/**
 * Class UserEntity
 * @package Buisness\User\Entity
 */
final class UserInfoEntity implements IUserInfoEntity
{
    private string $name;

    private int $id;

    private string $second_name;

    private string $description;

    public function __construct(string $name, string $second_name, string $description, int $id)
    {
        $this->name = $name;
        $this->second_name = $second_name;
        $this->description = $description;
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSecondName(): string
    {
        return $this->second_name;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
