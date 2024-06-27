<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderToCategory extends Model
{
    use HasFactory;

    protected $table = 'order_to_category';

    protected $fillable = [
        'category_id',
        'order_id',
        'created_at',
        'updated_at'
    ];

}
