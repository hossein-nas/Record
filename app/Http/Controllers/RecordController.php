<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Morilog\Jalali\Jalalian;
use \Carbon\Carbon;
use \App\Traits\CardCreatorTrait;

class RecordController extends Controller
{
    public function index()
    {
        $this->execPython();

        if (!$this->isMasterSet()) {
            return view('master_set');
        }
        return view('home');
    }

    public function recharge_card()
    {

        if (request()->has('uid')) {
            $uid = request()->get('uid');
            $plan_id = request()->get('plan');
            $plan = \App\Plan::find($plan_id);
            $plan_period = $plan->period;
            $card = CardCreatorTrait::getCard($uid);

            $active_plan = $this->checkForActivePlan($card->member);

            if ($active_plan) {
                return collect([
                    'result' => 'active_plan'
                ])->toJson();
            }

            $_start_at = request()->get('start_at');
            $_start_at_timestamp = \Morilog\Jalali\Jalalian::fromFormat('Y/n/j', $_start_at)->getTimestamp();
            $start_at = Carbon::createFromTimestamp($_start_at_timestamp);


            $data = [
                'member_id' => $card->member->id,
                'admin_id' => 1,
                'plan_id' => $plan_id,
                'start_at' => $start_at->toDateTimeString(),
                'finished_at' => $start_at->add($plan_period, 'day')->toDateTimeString()
            ];

            $ret = \App\MemberPlan::create($data);

            if ($ret) {
                return collect([
                    'result' => 'ok',
                    'data' => [
                        'card' => $card,
                        'member' => $card->member,
                    ]
                ])->toJson();
            }
        }


        return collect([
            'result' => 'error'
        ])->toJson();
    }

    public function recharge_card_page()
    {
        $plans = \App\Plan::all();
        $today = Jalalian::now()->format('Y/n/j');
        return view('recharge_card', ['plans' => $plans, 'today' => $today]);
    }

    public function register_new_page()
    {

        return view("register_new");
    }


    public function get_card_info()
    {

        if (request()->has('uid')) {
            $uid = request()->get('uid');
            $card = CardCreatorTrait::getCard($uid);
            if ($card->member->plan->count()) {
                $finished_at = $card->member->plan->last()->pivot->finished_at;
                $remaining_days = \Carbon\Carbon::now()->DiffInDays($finished_at, false);
            } else {
                $remaining_days = 0;

            }

            return collect([
                'result' => 'ok',
                'data' => [
                    'card' => $card,
                    'member' => $card->member,
                    'remaining_days' => $remaining_days
                ]
            ])->toJson();
        }

        return collect([
            'result' => 'error'
        ])->toJson();

    }

    public function register_new()
    {

        $card = [
            'uid' => request()->get('uid'),
            'registered_at' => Carbon::now(),
            'type' => 'user'
        ];
        $c = CardCreatorTrait::createCard($card);
        if ($c != null) {
            $member = [
                'name' => strtoupper(request()->get('user_name')),
                'lastname' => strtoupper(request()->get('user_lastname')),
                'national_code' => request()->get('user_national_code'),
                'telephone' => request()->get('user_telephone'),
                'mobile_number' => request()->get('user_mobile_number'),
                'address' => request()->get('user_address'),
                'card_id' => $c->id
            ];
            $m = \App\Member::create($member);
            return collect([
                'result' => 'ok',
                'data' => [
                    'member' => $m,
                    'card' => $c
                ]
            ]);
        }

        return collect([
            'result' => 'error'
        ]);
    }


    public function get_info()
    {
        $todays_workout = \App\Workout::where('action_at', '>', \Carbon\Carbon::now()->today())->where('action', 'exit')->get()->count();
        $todays_registered = \App\MemberPlan::where('start_at', '>', \Carbon\Carbon::now()->today())->get()->count();
        $ret = array(
            "weakday_name" => Jalalian::now()->format('l'),
            "date" => Jalalian::now()->format('y/m/d'),
            "hour" => Jalalian::now()->format('H'),
            "minute" => Jalalian::now()->format('i'),
            "second" => Jalalian::now()->format('s'),
            'todays_workout' => $todays_workout,
            'todays_registered' => $todays_registered
        );

        return $ret;
    }

    public function get_cabinet_info()
    {
        $all_cabinets = \App\Cabinet::all();
        if (request()->has('init')) {
            return $all_cabinets->toJson();
        }
    }

    public function cabinet_status($cabinet_id)
    {
        $workout = \App\Workout::where('cabinet_id', $cabinet_id)->get()->last();
        $member = \App\Member::find($workout->member_id);
        return view('cabinet_status', ['workout' => $workout, 'member' => $member]);
    }

    public function cabinet_empty($id)
    {
        if (request()->has('workout')) {
            $workout_id = request()->get('workout');
            $workout = \App\Workout::find($workout_id);
            if ($workout) {
                $cabinet_id = $workout->cabinet_id;
                $new = \App\Workout::create([
                    'member_id' => $workout->member_id,
                    'cabinet_id' => $workout->cabinet_id,
                    'action' => 'exit',
                    'action_at' => \Carbon\Carbon::now()
                ]);

                $cabinet = \App\Cabinet::find((int)$cabinet_id);
                $cabinet->status = 0;
                $cabinet->save();
            }
        }
        return redirect("/");
    }

    public function ajaxCommand()
    {
        if (request()->has('command')) {
            $command = request()->get('command');
            $ret = $this->sendCommand($command);
            $result = [
                'result' => $ret
            ];
            return json_encode($result);
        }
        return 'error.';
    }


    public function cabinetManager()
    {
        if (request()->has('uid')) {
            $uid = request()->get('uid');
            $uid = substr($uid, 3);
            try {

                $card = \App\Card::where('uid', $uid)->get()->first();
                if (!$card) {
                    $this->sendCommand("#UNAUTHORIZED");
                    return;
                }

                $member = $card->member;
                $member_name = $member->lastname;
                if (strlen($member_name) > 12) {
                    $member_name = substr($member_name, 0, 11);
                }


                if (!$member->plan->count()) {
                    $this->sendCommand("#NOCHARGE[" . strtoupper($member_name) . "]");
                    return;
                }

                $finished_at = $member->plan->last()->pivot->finished_at;
                $remaining_days = \Carbon\Carbon::now()->DiffInHours($finished_at, false);
                if ($remaining_days <= 0) {
                    $this->sendCommand("#NOCHARGE[" . strtoupper($member_name) . "]");
                    return;
                }


                // check for last login/logout
                $action = 'entry';
                $last_login = \App\Workout::where('member_id', $member->id)->get()->last();
                if ($last_login == null) {
                    $action = 'entry';
                } else if ($last_login->action == 'entry') {
                    $action = 'exit';
                } else if ($last_login->action == 'exit') {
                    $action = 'entry';
                }


                if ($action == 'entry') {
                    $cabinet = $this->getActiveCabinet($member);
                    $cabinet->status = 1;
                    $cabinet->save();
                    $ret = \App\Workout::create([
                        'member_id' => $member->id,
                        'cabinet_id' => $cabinet->cabinet_no,
                        'action' => 'entry',
                        'action_at' => \Carbon\Carbon::now()
                    ]);

                    $command = "#ENTRY[";
                    $command .= strtoupper($member_name);
                    $command .= "-" . $cabinet->id . "]";
                    $cabinet_no = $cabinet->cabinet_no - 1;
                    $cabinet_command = "#CABINET" . $cabinet_no;
                    $this->sendCommand($command);
                    $this->sendCabinet($cabinet_command);
                } else {
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
                    $this->sendCommand("#EXIT[" . $cabinet->id . "]");
                    $cabinet_no = $cabinet->cabinet_no - 1;
                    $cabinet_command = "#CABINET" . $cabinet_no;
                    $this->sendCabinet($cabinet_command);
                }


            } catch (Exception $e) {
                return false;
            }


        }
    }

    public function _cabinetManager()
    {

        if (request()->has('newcard')) {
            $file = fopen('newcard.txt', 'a');
            $txt = request()->get('newcard') . "\n";
            fwrite($file, $txt);
            fclose($file);
        }
        return "OK.";
    }

    private function isMasterSet()
    {
        return $admins_counts = \App\Admin::all()->count();;
    }

    private function execPython()
    {
        $command = escapeshellcmd('bash ./bash.sh');
        $output = shell_exec($command);
        return true;
    }

    private function sendCommand($command)
    {
        $host = "127.0.0.1";
        $port = 1234;
        $message = "ready?" . "\n";
        // create socket
        $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
        // connect to server
        $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");
        // send string to server
        socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
        // get server response
        $result = socket_read($socket, 1024) or die("Could not read server response\n");
        if (trim($result) == 'ready') {
            $message = $command;
            socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
            $result = socket_read($socket, 1024) or die("Could not read server response\n");
            $result = trim($result);
            $result_len = strlen($result);
            if ($result == 'done.') {
                socket_close($socket);
                return 'done.';
            } else if (substr($result, 0, 7) == "NEWCARD") {
                socket_close($socket);
                return substr($result, 8);
            }
        }
        socket_close($socket);
        return 'NOT DETECTED.';
    }

    private function sendCabinet($cabinet)
    {
        $host = "127.0.0.1";
        $port = 4321;
        $message = "ready?" . "\n";
        // create socket
        $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
        // connect to server
        $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");
        // send string to server
        socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
        // get server response
        $result = socket_read($socket, 1024) or die("Could not read server response\n");
        if (trim($result) == 'ready') {
            $message = $cabinet;
            socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
        }
        socket_close($socket);
        return 'DONE.';
    }

    private function checkForActivePlan($member)
    {
        $plan = \App\MemberPlan::where('member_id', $member->id)->where('finished_at', '>', Carbon::now());
        return $plan->count();
    }

    private function getActiveCabinet($member)
    {
        // first checks for last exit and if last_exit < 5min returns that cabinet_id
        $member_id = $member->id;
        $last_exit_member = \App\Workout::where('member_id', $member_id)->where('action', 'exit')->get();
        if ($last_exit_member->count()) {
            $last_exit_member = $last_exit_member->last();
            $action_at = $last_exit_member->action_at;
            $last_exit_in_minute = \Carbon\Carbon::now()->diffInMinutes($action_at);
            if ($last_exit_in_minute < 5) {
                $cabinet = \App\Cabinet::find($last_exit_member->cabinet_id);
                return $cabinet;
            }
        }

        // in this section checks all cabinets
        // and if last_exit on cabinet without attention for member (just exit_time) excludes that
        // cabinet from available cabinets
        $all_cabinets = \App\Cabinet::where('status', 0)->get();
        $a = $all_cabinets->filter(function ($cabinet) {
            $workout = \App\Workout::where('cabinet_id', $cabinet->id)->where('action', 'exit')->get()->last();

            if ($workout != null) {
                $action_at = $workout->action_at;
                $last_exit_in_minute = \Carbon\Carbon::now()->diffInMinutes($action_at);
                if ($last_exit_in_minute > 5)
                    return true;
            } else if ($workout == null) {
                $cabinet_id = $cabinet->id;
                return true;
            } else {
                return false;
            }

        });
        $cabinet = \App\Cabinet::find($a->random()->cabinet_no);
        return $cabinet;
    }

}

