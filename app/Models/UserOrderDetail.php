<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrderDetail extends Model
{
    protected $table = 'user_order_detail';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'customer_name',
        'customer_company',
        'customer_address',
        'customer_email',
        'customer_phone',
        'sales_name',
        'sales_company',
        'sales_phone',
        'sales_email',
    ];

}
