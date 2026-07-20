<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'reseller_id',
        'customer_number',
        'customer_name',
        'customer_address',
        'customer_email',
        'customer_telp',
        'customer_company',
        'customer_password',
        'is_verified',
        'is_active',
        'is_logedin',
        'verified_code',
        'status_id',
        'created_by',
	    'modified_by',
    ];

    public function scopeOmniFilter($query) {

        if(session('company_id') != 1) {
            return $query->where('customer.reseller_id', session('reseller_id'));
        }
    
    }

}
