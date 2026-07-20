<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCompany extends Model
{
    protected $table = 'customer_company';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'company_id',
        'contact_type',
        'is_pic',
    ];

}
