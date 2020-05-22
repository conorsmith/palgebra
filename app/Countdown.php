<?php

namespace ConorSmith\Palgebra;

use Carbon\Carbon;

class Countdown
{
    public function getTimeRemaining($startedAt)
    {
        $startTime = new Carbon($startedAt, "Europe/Dublin");

        $endTime = $startTime->clone();
        $endTime->addSeconds(intval(config("game.time")));

        $now = Carbon::now("Europe/Dublin");
        $timeRemaining = $now->diffAsCarbonInterval($endTime, false);
        $timeRemaining->ceilSeconds();

        if ($endTime->greaterThan($now)) {
            return (object) [
                'minutes'      => str_pad(strval($timeRemaining->i), 2, "0", STR_PAD_LEFT),
                'seconds'      => str_pad(strval($timeRemaining->s), 2, "0", STR_PAD_LEFT),
                'totalSeconds' => intval(floor($timeRemaining->totalSeconds)),
            ];
        } else {
            return (object) [
                'minutes'      => "00",
                'seconds'      => "00",
                'totalSeconds' => 0,
            ];
        }
    }
}
