<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'users_info';
    protected $fillable = ['user_id', 'name', 'second_name', 'description'];

    static function getByUserIdOrCreate(int $user_id): Model|Builder|null
    {
        return self::query()
            ->firstOrCreate(['user_id' => $user_id], ['user_id' => $user_id]);
    }
}
