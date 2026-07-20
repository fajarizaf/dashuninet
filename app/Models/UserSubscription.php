<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $table = 'user_subscription';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'customer_id',
        'reseller_id',
        'subscription_number',
        'billing_account',
        'order_id',
        'subscription_date',
        'product_id',
        'product_name',
        'product_plan',
        'product_desc',
        'billingcycle',
        'amount',
        'next_due_date',
        'termination_date',
        'complete_date',
        'cancel_date',
        'deactive_date',
        'reactive_date',
        'dismentle_date',
        'progress_date',
        'suspend_reason',
        'is_publish',
        'is_free',
        'status_id',
        'expired_date',
    ];

    public function scopeOmniFilter($query) {

        if(session('company_id') != 1) {
            return $query->where('user_subscription.reseller_id', session('reseller_id'));
        }
    
    }

}
