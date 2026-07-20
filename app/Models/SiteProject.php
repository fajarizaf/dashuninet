<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteProject extends Model
{
        protected $table = 'site_project';
        protected $primaryKey = 'id';

        public $timestamps = true;

        protected $fillable = [
                'router_id',
                'project_name',
                'project_address',
                'project_description',
                'project_goals',
                'project_start',
                'project_end',
                'status'
        ];

}
