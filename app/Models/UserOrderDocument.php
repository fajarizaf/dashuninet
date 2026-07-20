<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrderDocument extends Model
{
    protected $table = 'user_order_document';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'document_number',
        'document_type',
        'document_name',
    ];

}
