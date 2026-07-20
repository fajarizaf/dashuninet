<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
        protected $table = 'documentations';
        protected $primaryKey = 'id';

        public $timestamps = true;

        protected $fillable = [
                'title',
                'slug',
                'content',
                'attachment',
                'is_visible',
                'type',
                'app'
        ];

}
