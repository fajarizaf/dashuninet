<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestDeposit extends Model
{
    protected $table = 'request_deposit';
    protected $primaryKey = 'id';
    

    public $timestamps = true;

    protected $fillable = [
        'customer_id',
        'invoice_id',
        'payment_method',
        'amount',
        'request_date',
        'process_date',
        'status_id'
    ];

    // Relasi dengan Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relasi dengan UserInvoices
    public function invoice()
    {
        return $this->belongsTo(UserInvoices::class, 'invoice_id');
    }

    // Relasi dengan SiteStatus untuk status
    public function status()
    {
        return $this->belongsTo(\App\Models\SiteStatus::class, 'status_id');
    }

}
