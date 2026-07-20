<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $table = 'log_activity';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'module',
        'module_id',
        'log_label',
        'log_entry',
        'log_user_name',
        'log_user_id',
        'log_user_ip',
    ];

}
