<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptionField extends Model
{
    protected $table = 'user_subscription_field';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'subscription_id',
        'field_type',
        'field',
        'value',
    ];

}
