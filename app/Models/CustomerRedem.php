<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRedem extends Model
{
    protected $table = 'customer_redem';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'reward_id',
        'customer_id',
        'redem_status',
        'expedition_id',
    ];

}
