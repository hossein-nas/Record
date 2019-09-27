<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $fillable = [
        'name', 'lastname', 'card_id'
    ];
    public $timestamps = false;
}
