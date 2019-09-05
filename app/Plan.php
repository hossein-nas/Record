<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plan';
    protected $fillable = [
        'name', 'price' , 'period'
    ];
    public $timestamps = false;


    public function members(){
        return $this->belongsToMany('App\Member', 'member_plan', 'plan_id', 'member_id');
    }
}
