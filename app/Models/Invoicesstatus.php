<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoicesstatus extends Model
{
    protected $table = 'invoices_status';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'status_name',
        'status_slug',
        'status_desc',
    ];

}
