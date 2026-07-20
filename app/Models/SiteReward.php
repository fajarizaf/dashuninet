<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteReward extends Model
{
        protected $table = 'site_reward';
        protected $primaryKey = 'id';

        public $timestamps = true;

        protected $fillable = [
                'reward_name',
                'reward_point',
                'reward_description',
                'reward_cover',
                'status'
        ];

}
