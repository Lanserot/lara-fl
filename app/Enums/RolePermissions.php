<?php

namespace App\Enums;

enum RolePermissions: string
{
    case API = 'api';

    public function getDescription(): string
    {
        return match($this) {
            self::API => 'Возможность работать с API',
        };
    }
}
