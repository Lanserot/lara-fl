<?php

declare(strict_types=1);

namespace App\Enums;

enum HttpStatuses: int
{
    case SUCCESS = 200;
    case FOUND = 302;
    case BAD_REQUEST = 400;

    case ACCESS_DENIED = 403;
    case NOT_FOUND = 404;
    case ERROR = 500;
    case UNKNOWN_ERROR = 520;

    public function getDescription(): string
    {
        return match ($this) {
            self::SUCCESS => 'Успешный запрос',
            self::FOUND => 'Найдено',
            self::BAD_REQUEST => 'Неверный запрос',
            self::NOT_FOUND => 'Не найдено',
            self::ERROR => 'Внутренняя ошибка сервера',
            self::UNKNOWN_ERROR => 'Неизвестная ошибка',
            self::ACCESS_DENIED => 'Недостаточно прав',
        };
    }
}
