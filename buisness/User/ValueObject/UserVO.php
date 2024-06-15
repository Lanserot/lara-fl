<?php

declare(strict_types=1);

namespace Buisness\User\ValueObject;

/**
 * Class UserVO
 * @package Buisness\User
 */
class UserVO
{
    public const KEY_LOGIN = 'login';
    public const KEY_PASSWORD = 'password';
    public const KEY_ID = 'id';
    public const KEY_EMAIL = 'email';

    private string $login;
    private string $password;
    private string $email;
    private int $id;

    private function __construct(
        string $login,
        int    $id,
        string $email,
        string $password,
    )
    {
        $this->login = $login;
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }

    static function get(
        string $login,
        int    $id,
        string $email,
        string $password,
    ): UserVO
    {
        return new self($login, $id, $email, $password);
    }

    static function getNull(): UserVO
    {
        return new self('', 0, '', '');
    }

    public function isNull(): bool
    {
        return $this->login == '' && $this->id == 0 && $this->email == '' && $this->password == '';
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
            self::KEY_EMAIL => $this->email,
        ];
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
