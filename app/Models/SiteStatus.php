<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteStatus extends Model
{
    protected $table = 'site_status';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'status_name',
        'status_slug',
        'status_desc',
    ];

}
