<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteProductPrice extends Model
{
    protected $table = 'site_product_price';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'payment_type',
        'billing_cycle',
        'setup_fee',
        'price',
        'enabled',
    ];

}
