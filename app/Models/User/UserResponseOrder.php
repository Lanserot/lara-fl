<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserResponseOrder
 * @package App\Models\User
 * @property int $user_id
 * @property int $order_id
 * @property int $owner_id
 */
class UserResponseOrder extends Model
{
    use HasFactory;

    protected $table = 'user_response_order';
    protected $fillable = ['user_id', 'order_id'];
    
    public function user_info()
    {
        return $this->belongsTo(\App\Models\User\UserInfo::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(\App\Models\Order\Order::class, 'order_id', 'id');
    }
}
