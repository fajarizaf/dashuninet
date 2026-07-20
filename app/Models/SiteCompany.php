<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteCompany extends Model
{
    protected $table = 'site_company';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'parentid',
        'company_name',
        'company_address',
        'company_owner',
        'company_email',
        'company_telp',
        'zipcode',
        'status_id'
    ];

}
