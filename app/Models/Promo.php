<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promo';
    protected $primaryKey = 'id';
    
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    public $timestamps = true;

    protected $fillable = [
        'promotion_code',
        'promotion_label',
        'promotion_desc',
        'type',
        'subscription_month',
        'value',
        'period_free',
        'setup_free',
        'start_date',
        'end_date',
        'max_user',
        'is_active'
    ];

}
