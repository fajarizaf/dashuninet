<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTicketReply extends Model
{
    protected $table = 'user_ticket_reply';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'ticket_id',
        'message',
        'attachment',
        'created_by',
        'created_by_name',
        'created_by_position',
        'created_at',
        'updated_at',
    ];

}
