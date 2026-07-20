<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteProductGroup extends Model
{
    protected $table = 'site_product_group';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'product_group_name',
        'product_group_headline',
        'product_group_tagline',
        'is_hidden',
    ];

}
