<?php

declare(strict_types=1);

namespace Buisness\User\ValueObject;

/**
 * Class UserVO
 * @package Buisness\User
 */
class UserLoginVO
{
    public const KEY_LOGIN = 'login';
    public const KEY_PASSWORD = 'password';

    private string $login;
    private string $password;

    private function __construct(
        string $login,
        string $password,
    )
    {
        $this->login = $login;
        $this->password = $password;
    }

    static function get(
        string $login,
        string $password,
    ): UserLoginVO
    {
        return new self($login, $password);
    }

    static function getNull(): UserLoginVO
    {
        return new self('', '');
    }

    public function isNull(): bool
    {
        return $this->login == '' && $this->password == '';
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function toArray(): array
    {
        return [
            self::KEY_LOGIN => $this->login,
            self::KEY_PASSWORD => $this->password,
        ];
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
