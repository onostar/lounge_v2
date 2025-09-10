<?php
date_default_timezone_set("Africa/Lagos");

function getCustomDay(){
    $now = new DateTime();
    $hour = (int)$now->format('H');
    if($hour >= 12){
        $start_time = new DateTime('12:00 today');
        $end_time = new DateTime('12:00 tomorrow');

    }else{
        $start_time = new DateTime('12:00 yesterday');
        $end_time = new DateTime('12:00 today');
    }

    return [
        'start' => $start_time->format('Y-m-d H:i:s'),
        'end' =>$end_time->format('Y-m-d H:i:s')
    ];
}
