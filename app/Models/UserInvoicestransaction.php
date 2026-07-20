<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInvoicestransaction extends Model
{
    protected $table = 'user_invoices_transaction';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'reseller_id',
        'trx_number',
        'invoice_id',
        'trx_date',
        'currency',
        'gateway',
        'is_deposit',
        'amount_in',
        'fees',
        'amount_out',
        'description',
        'payment_status',
        'transid',
        'refundid',
        'created_at',
        'updated_at'
    ];

    public function scopeOmniFilter($query) {

        if(session('company_id') != 1) {
            return $query->where('user_invoices_transaction.reseller_id', session('reseller_id'));
        }
    
    }
}
