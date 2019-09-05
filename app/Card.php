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
    //
}
