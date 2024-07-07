<?php

namespace Infrastructure\Enums;

enum RolesEnum: string
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
