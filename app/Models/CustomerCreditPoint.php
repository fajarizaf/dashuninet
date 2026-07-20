<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCreditPoint extends Model
{
    protected $table = 'customer_credit_point';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'redem_id',
        'customer_id',
        'amount_in',
        'amount_out',
        'credit_type',
    ];

}
