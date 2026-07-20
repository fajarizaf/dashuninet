<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrderItem extends Model
{
    protected $table = 'user_order_item';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_plan',
        'product_desc',
        'promo',
        'billing_cycle',
        'unit_price',
        'quantity',
        'discount',
        'tax_rate',
    ];

}
