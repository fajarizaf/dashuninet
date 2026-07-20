<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrderField extends Model
{
    protected $table = 'user_order_field';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'field_type',
        'product_id',
        'order_item_id',
        'field',
        'value',
    ];

}
