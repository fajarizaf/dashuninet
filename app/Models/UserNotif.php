<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotif extends Model
{
    protected $table = 'user_notifs';
    protected $primaryKey = 'id';

    public $timestamps = true;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'subject',
        'message',
        'readable',
        'user',
        'user_id',
        'group_id'
    ];

}
