<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pipeline extends Model
{
    protected $table = 'pipeline';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'reseller_id',
        'pic_name',
        'position_name',
        'place_of_bussines',
        'area',
        'exist_product',
        'price_product',
        'bandwidth_product',
        'keterangan',
        'telp',
        'email',
        'created_by',
	    'modified_by',
        'is_hidden',
        'nama_jalan',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'link_maps',
        'jenis_bangunan',
    ];

    public function scopeOmniFilter($query) {

        if(session('company_id') != 1) {
            return $query->where('pipeline.reseller_id', session('reseller_id'));
        }
    
    }

}
