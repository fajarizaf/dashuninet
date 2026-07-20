<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicesProofPayment extends Model
{
    protected $table = 'invoices_proof_payment';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'invoice_id',
        'file',
        'status',
        'reject_reason',
    ];

}
