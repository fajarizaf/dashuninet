<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteRouter extends Model
{
        protected $table = 'site_router';
        protected $primaryKey = 'id';

        public $timestamps = true;

        protected $fillable = [
                'label_name',
                'ipaddress',
                'username',
                'password',
                'status',
        ];

}
