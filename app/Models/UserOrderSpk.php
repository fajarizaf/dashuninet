<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrderSpk extends Model
{
    protected $table = 'user_order_spk';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'spk_type',
        'spk_number',
        'spk_date',
        'spk_to',
        'spk_cc',
        'cust_bill_id',
        'subject',
        'execution_date',
        'working_list',
        'upgrade_date',
        'signature_ba',
        'signature_acknowledge',
        'signature_executed',
        'name_ba',
        'name_acknowledge',
        'name_executed',
    ];

}
