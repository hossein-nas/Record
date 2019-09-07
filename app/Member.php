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
        'national_code',
        'mobile_number',
        'card_id'
    ];

    public function plan(){
        return $this->belongsToMany('App\Plan', 'member_plan', 'member_id', 'plan_id')->withPivot('start_at', 'finished_at');
    }

    public function card(){
        return $this->hasOne('App\Card', 'card_id');
    }
}
