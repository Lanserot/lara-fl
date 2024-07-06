<?php

namespace Infrastructure\Enums;

enum RolePermissionsEnum: string
{
    case API = 'api';
    case API_USER = 'api_user';

    public function getDescription(): string
    {
        return match($this) {
            self::API => 'Возможность работать с API',
            self::API_USER => 'Возможность работать с API пользователю',
        };
    }

}
