<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Morilog\Jalali\Jalalian;

class RecordController extends Controller
{
    public function index(){
        return view('home');
    }


    public function get_info(){
        $ret = array(
            "weakday_name" => Jalalian::now()->format('l'),
            "date" => Jalalian::now()->format('y/m/d'),
            "hour" =>  Jalalian::now()->format('H'),
            "minute" =>  Jalalian::now()->format('i'),
            "second" =>  Jalalian::now()->format('s'),
        );
        
        return $ret ;
    }
    
}
