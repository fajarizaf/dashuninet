<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteTicketDepartment extends Model
{
    protected $table = 'site_ticket_department';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'status_name',
        'status_slug',
        'status_desc',
    ];

}
