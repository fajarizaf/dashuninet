<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInvoicespayment extends Model
{
    protected $table = 'user_invoices_payment';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'invoice_id',
        'txnId',
        'txnAmount',
        'txnChannel',
        'txnDateTime',
        'txnDueDateTime',
        'va',
    ];

}
