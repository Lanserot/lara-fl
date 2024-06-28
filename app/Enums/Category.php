<?php

namespace App\Enums;

enum Category: string
{
    CASE PROGRAMMING =  'programming';
    CASE MODEL_3D =     'model_3d';
    CASE WEBSITES =     'websites';
    CASE GAMES =        'games';
    CASE DESIGN =       'design';
    CASE TEXTS =        'texts';

    public function getNameRus(): string
    {
        return match($this) {
            self::PROGRAMMING => 'Программирование',
            self::MODEL_3D => '3д',
            self::WEBSITES => 'Сайты',
            self::GAMES => 'Игры',
            self::DESIGN => 'Дизайн',
            self::TEXTS => 'Тексты',
        };
    }
}
