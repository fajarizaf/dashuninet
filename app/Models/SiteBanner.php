<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteBanner extends Model
{
        protected $table = 'site_banner';
        protected $primaryKey = 'id';

        public $timestamps = true;

        protected $fillable = [
                'banner_name',
                'banner_link',
                'is_hidden',
                'category'
        ];

}
