<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public string $role;
    public const FIELD_LOGIN = 'login';
    public const FIELD_PASSWORD = 'password';
    public const FIELD_EMAIL = 'email';
    public const FIELD_ID = 'id';

    public const FIELD_ROLE_ID = 'role_id';

    protected $fillable = [
        self::FIELD_LOGIN,
        self::FIELD_EMAIL,
        self::FIELD_PASSWORD,
        self::FIELD_ID,
        self::FIELD_ROLE_ID,
    ];

    protected $hidden = [
        self::FIELD_PASSWORD,
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        self::FIELD_PASSWORD => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
