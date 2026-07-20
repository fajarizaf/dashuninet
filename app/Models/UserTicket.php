<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTicket extends Model
{
    protected $table = 'user_ticket';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'customer_id',
        'reseller_id',
        'department_id',
        'customer_name',
        'title',
        'message',
        'attachment',
        'priority',
        'status_id',
        'due_date',
        'close_date',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'ticket_number'
    ];

    public function scopeOmniFilter($query)
    {

        if (session('company_id') != 1) {
            return $query->where('user_ticket.reseller_id', session('reseller_id'));
        }

    }

}
