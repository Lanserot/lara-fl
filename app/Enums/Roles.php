<?php

namespace App\Enums;

enum Roles: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public function getDescription(): string
    {
        return match($this) {
            self::ADMIN => 'Администратор',
            self::USER => 'Пользователь',
        };
    }
}
