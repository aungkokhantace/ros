<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/26/2016
 * Time: 10:55 AM
 */

namespace App\RMS;


class CheckingBooking
{
    public static function checking($tables,$rooms,$flag1,$flag2,$from_seconds,$to_seconds,$to,$table_id,$room_id,$capacity){
        //check from_time is greater than to_time or not
        if($from_seconds > $to_seconds && $to != ""){
            alert()->warning('To_time should be greater than From_time!')->persistent('Close');
            return back();
        }
        //check table seat

        // foreach($tables as $table){
        //     if($table_id == $table->id && $capacity > $table->capacity){
        //         $flag1 = 'true';
        //     }
        // }
        // if($flag1 == 'true'){
        //     alert()->warning('More Than Seat')->persistent('Close');
        //     return $flag1;
        // }
        // //check room capacity

        // foreach($rooms as $room){
        //     if($room_id == $room->id && $capacity > $room->capacity){
        //         $flag2 = 'true';
        //     }
        // }
        // if($flag2 == 'true'){
        //     alert()->warning('More than room capacity')->persistent('Close');
        //     return $flag2;
        // }
    }
}