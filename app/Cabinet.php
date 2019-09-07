<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cabinet extends Model
{
    protected $table = 'cabinet';
    protected $fillable = [
        'cabinet_no','status'
    ];

    public $timestamps = false;
    private $cabinet_counts = 16;

    public function getCabinetCounts(){
        return $this->cabinet_counts;
    }
}
