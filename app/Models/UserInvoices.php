<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\SiteStatus;
use App\Models\InvoicesProofPayment;

class UserInvoices extends Model
{
    protected $table = 'user_invoices';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'reseller_id',
        'invoice_number',
        'invoice_type',
        'customer_id',
        'invoice_date',
        'invoice_duedate',
        'invoice_next_duedate',
        'invoice_datepaid',
        'payment_method',
        'tax',
        'subtotal',
        'total',
        'is_publish',
        'file_invoices',
        'file_faktur',
        'status_id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function scopeOmniFilter($query) {

        if(session('company_id') != 1) {
            return $query->where('user_invoices.reseller_id', session('reseller_id'));
        }
    
    }

    /**
     * Relasi ke tabel invoices_proof_payment
     */
    public function invoicesProofPayment()
    {
        return $this->hasMany(InvoicesProofPayment::class, 'invoice_id', 'id');
    }

    /**
     * Relasi ke customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Relasi ke status
     */
    public function status()
    {
        return $this->belongsTo(SiteStatus::class, 'status_id', 'id');
    }
}
