<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInvoicesitem extends Model
{
    protected $table = 'user_invoices_item';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'billing_account',
        'invoice_id',
        'product_id',
        'item_name',
        'item_description',
        'item_type',
        'tax',
        'quantity',
        'amount',
        'notes',
    ];

}
