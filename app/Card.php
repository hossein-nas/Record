<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'card';
    protected $fillable = [
        'uid', 'registered_at' , 'type'
    ];
    public $timestamps = false;

    public function member(){
        return $this->belongsTo('App\Member', 'id', 'card_id');
    }
    //
}
