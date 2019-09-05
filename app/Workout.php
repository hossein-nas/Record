<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $table = 'workout';
    protected $fillable = [
        'member_id', 'cabinet_id', 'action', 'action_at'
    ];
    protected $casts = [
        'action_at' => 'datetime'
    ];
    public $timestamps = false;
}
