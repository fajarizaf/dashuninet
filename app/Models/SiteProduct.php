<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteProduct extends Model
{
    protected $table = 'site_product';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'reseller_id',
        'product_type',
        'product_group',
        'product_scope',
        'product_name',
        'product_plan',
        'product_desc',
        'apply_tax',
        'product_stock',
        'is_hidden',
        'product_template_email',
        'deposit_payment',
        'allow_promo'
    ];

    public function scopeOmniFilter($query) {

        if(session('company_id') != 1) {
            return $query->where('site_product.reseller_id', session('reseller_id'));
        }
    
    }
}
