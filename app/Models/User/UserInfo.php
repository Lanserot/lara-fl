<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserInfo
 * @package App\Models\User
 *
 * @property int $user_id
 * @property int $id
 * @property int $order_id
 * @property int $avatar_id
 * @property string $second_name
 * @property string $name
 * @property string $description
 */
class UserInfo extends Model
{
    protected $table = 'users_info';
    protected $fillable = [
        'user_id',
        'name',
        'second_name',
        'description',
        'avatar_id'
    ];

    static function getByUserIdOrCreate(int $user_id): ?Model
    {
        return self::query()->firstOrCreate(['user_id' => $user_id]);
    }
}
