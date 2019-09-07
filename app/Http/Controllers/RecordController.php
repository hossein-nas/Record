<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Morilog\Jalali\Jalalian;

class RecordController extends Controller
{
    public function index(){
        $this->execPython();
        
        if ( !$this->isMasterSet() ){
            return view('master_set');
        }
        return view('home');
    }

    public function register_new(){
        return view("register_new");
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

    public function get_cabinet_info(){
        $all_cabinets = \App\Cabinet::all();
        if (request()->has('init')){
            return $all_cabinets->toJson();
        }
    }

    public function ajaxCommand(){
        if ( request()->has('command') ){
            $command = request()->get('command');
            $ret = $this->sendCommand($command);
            return $ret;
        }
        return 'error.';
    }
        
        
    public function cabinetManager(){
        if ( request()->has('uid') ){
            $uid = request()->get('uid');
            $uid = substr($uid,3);
            try{
                
                $card = \App\Card::where('uid', $uid)->get()->first();
                if(!$card){
                    $this->sendCommand("#UNAUTHORIZED"); 
                    return;
                }
                
                $member = $card->member;
                if (!$member->plan->count()){
                    $this->sendCommand("#NOCHARGE[".strtoupper($member->lastname)."]");
                    return;
                }
                
                $finished_at = $member->plan->last()->pivot->finished_at;
                
                // check for last login/logout
                $action = 'entry';
                $last_login = \App\Workout::where('member_id', $member->id)->get()->last();
                if ( $last_login == null){
                    $action = 'entry';
                }else if ($last_login->action == 'entry' ){
                    $action = 'exit';
                }
                else if ( $last_login->action == 'exit'){
                    $action = 'entry';
                }
                
                
                if ($action == 'entry' ){
                    $cabinet = \App\Cabinet::where('status','0')->first();
                    $cabinet->status = 1;
                    $cabinet->save();
                    $ret = \App\Workout::create([
                        'member_id' => $member->id,
                        'cabinet_id' => $cabinet->cabinet_no,
                        'action' => 'entry',
                        'action_at' => \Carbon\Carbon::now()
                        ]);
                    $command = "#ENTRY[";
                    $command .= strtoupper($member->lastname);
                    $command .= "-".$cabinet->id."]";
                    $this->sendCommand($command);
                }
                else{
                    $ret = \App\Workout::where('member_id', $member->id)->get()->last();
                    $cabinet = \App\Cabinet::find($ret->cabinet_id);
                    $cabinet->status = 0;
                    $cabinet->save();
                    \App\Workout::create([
                        'member_id' => $member->id,
                        'cabinet_id' => $cabinet->cabinet_no,
                        'action' => 'exit',
                        'action_at' => \Carbon\Carbon::now()
                        ]);
                        $this->sendCommand("#EXIT[".$cabinet->id."]");
                }
                        
                        
            }catch(Exception $e){
                return false;
            }
                    
                    
        }
    }
            
    public function _cabinetManager(){
        
        if ( request()->has('newcard') ){
            $file = fopen('newcard.txt', 'a');
            $txt = request()->get('newcard') . "\n";
            fwrite($file, $txt);
            fclose($file);
        }
        return "OK.";
    }
            
    private function isMasterSet(){
        return $admins_counts = \App\Admin::all()->count();;
    }
    
    private function execPython(){
        $command = escapeshellcmd('bash ./bash.sh');
        $output = shell_exec($command);
        return true;
    }
            
    private function sendCommand($command){
        $host    = "127.0.0.1";
        $port    = 1234;
        $message = "ready?". "\n";
        // create socket
        $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
        // connect to server
        $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
        // send string to server
        socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
        // get server response
        $result = socket_read ($socket, 1024) or die("Could not read server response\n");
        if ( trim($result) == 'ready'){
            $message = $command;
            socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
            $result = socket_read ($socket, 1024) or die("Could not read server response\n");
            $result = trim($result);
            $result_len = strlen($result);
            if ( $result == 'done.' ){
                socket_close($socket);
                return 'done.';
            }
            else if ( substr($result,0,7) == "NEWCARD" ){
                socket_close($socket);
                return substr($result,8);
            }
        }
        socket_close($socket);
        return 'NO RESULT.';
    }
            
}
        