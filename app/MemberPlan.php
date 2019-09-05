<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberPlan extends Model
{
    protected $table = 'member_plan';
    protected $fillable = [
        'member_id', 'plan_id', 'admin_id', 'start_at', 'finished_at'
    ];

    protected $casts =[
        'start_at' => 'datetime',
        'finished_at' => 'datetime'
    ];
}
