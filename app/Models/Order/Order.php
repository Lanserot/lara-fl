<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const FIELD_TITLE = 'title';
    public const FIELD_DESCRIPTION = 'description';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'created_at',
        'updated_at',
    ];
}
