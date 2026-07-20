<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    protected $table = 'ticket_status';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'status_name',
        'status_slug',
        'status_desc',
    ];

}
