<?php

namespace App\Traits;

use \App\Member;
use \Carbon\Carbon;

trait ManageUsers
{
    public function showInfoPage($id)
    {
        $member = Member::findOrFail($id);
        if (!$member) {
            return die('error');
        }
        if ($member->plan->count()) {
            $member_finished_at = $member->plan->last()->pivot->finished_at;
            $remaining_days = Carbon::now()->diffInDays($member_finished_at, false);
            if ($remaining_days >= 0) {
                $remaining_days++;
            } else {
                $remaining_days = 0;
            }
        }
        else
            $remaining_days = 0;

        return view('userInfoPage', ["member" => $member, "remaining_days" => $remaining_days]);
    }
}
