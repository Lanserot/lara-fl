<?php

declare(strict_types=1);

namespace App\Http\Controllers\User\DTO;

/**
 * Class UserDTO
 * @package App\Http\Controllers\User\DTO
 */
class UserDTO
{
    public const KEY_LOGIN = 'login';
    public const KEY_ID = 'id';

    private string $login;
    private int $id;

    private function __construct(
        string $login,
        int    $id,
    )
    {
        $this->login = $login;
        $this->id = $id;
    }

    static function get(
        string $login,
        int    $id
    ): UserDTO
    {
        return new self($login, $id);
    }

    static function getNull(): UserDTO
    {
        return new self('', 0);
    }

    public function isNull(): bool
    {
        return $this->login == '' && $this->id == 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function toArray(): array
    {
        return [
            self::KEY_LOGIN => $this->login,
            self::KEY_ID => $this->id,
        ];
    }
}
