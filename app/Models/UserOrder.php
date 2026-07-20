<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    protected $table = 'user_order';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'order_number',
        'reseller_id',
        'order_section',
        'customer_id',
        'sales_id',
        'reference_id',
        'order_date',
        'target_to_live',
        'order_notes',
        'sub_total',
        'tax_rate',
        'vat',
        'total',
        'term_of_contract',
        'term_of_payment',
	    'is_publish',
        'is_approve',
        'is_rejected',
        'order_notes',
        'order_progress',
        'status_id',
        'payment_status'
    ];

    public function scopeOmniFilter($query) {

        if(session('company_id') != 1) {
            return $query->where('user_order.reseller_id', session('reseller_id'));
        }
    
    }


}
