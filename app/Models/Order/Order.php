<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'created_at',
        'updated_at',
    ];
}
