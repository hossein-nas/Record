<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    protected $fillable = [
        'name',
        'lastname',
        'address',
        'telephone',
        'mobile',
        'card_id'
    ];

    public function plan(){
        return $this->belongsToMany('App\Plan', 'member_plan', 'member_id', 'plan_id');
    }
}
