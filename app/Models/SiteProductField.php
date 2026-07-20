<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteProductField extends Model
{
    protected $table = 'site_product_field';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'order',
        'field_name',
        'field_slug',
        'field_type',
        'description',
        'select_options',
        'is_required',
        'show_order_form',
    ];

}
