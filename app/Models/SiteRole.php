<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteRole extends Model
{
    protected $table = 'site_role';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'role_name',
        'role_type',
        'role_department',
        'role_desc',
        'company_id',
        'created_by',
        'modified_by',
        'status_id',
    ];

}
