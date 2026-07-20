<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentation_cat extends Model
{
        protected $table = 'documentations_cat';
        protected $primaryKey = 'id';

        public $timestamps = false;

        protected $fillable = [
            'name_doc_cat'
        ];

}
