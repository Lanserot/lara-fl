<?php

namespace App\Models\Order;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const FIELD_TITLE = 'title';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_BUDGET = 'budget';
    public const FIELD_DATE = 'date';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'created_at',
        'updated_at',
        'budget',
        'date',
    ];

    protected function setDateAttribute($value)
    {
        if($value == ''){
            return null;
        }
        $this->attributes['date'] = Carbon::parse($value)->format('Y-m-d');
    }

    protected function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toDateString();
    }    
}
