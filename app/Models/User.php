<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public const FIELD_LOGIN = 'login';
    public const FIELD_PASSWORD = 'password';
    public const FIELD_EMAIL = 'email';

    protected $fillable = [
        self::FIELD_LOGIN,
        self::FIELD_EMAIL,
        self::FIELD_PASSWORD,
    ];

    protected $hidden = [
        self::FIELD_PASSWORD,
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        self::FIELD_PASSWORD => 'hashed',
    ];
}
