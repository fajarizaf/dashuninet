<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteExpedition extends Model
{
    protected $table = 'site_expedition';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'expedition_name',
        'expedition_status',
    ];

}
