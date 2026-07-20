<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    protected $table = 'reseller';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'reseller_name',
        'reseller_email',
        'reseller_phone',
        'reseller_address',
        'bandwidth',
        'status',
    ];

}
