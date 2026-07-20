<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProject extends Model
{
    protected $table = 'order_project';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'project_id',
    ];

    public function scopeOmniFilter($query) {

        if(session('company_id') != 1) {
            return $query->where('user_subscription.reseller_id', session('reseller_id'));
        }
    
    }

}
