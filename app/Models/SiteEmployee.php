<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteEmployee extends Model
{
        protected $table = 'site_employee';
        protected $primaryKey = 'id';

        public $timestamps = true;

        protected $fillable = [
                'name'
        ];

}
