<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerMembership extends Model
{
    protected $table = 'customer_membership';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'customer_id',
        'product_order',
        'referral_id',
        'referral_code',
        'level',
        'is_active',
        'points',
    ];

}
