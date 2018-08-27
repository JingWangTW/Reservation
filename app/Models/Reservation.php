<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    public static function createReservation ( $className, $classRoom, $startTime, $endTime, $assistant, $classIndex )
    {
        try
        {
            return DB::table('reservation_class')->insert([
                'class_name' => $className,
                'class_room' => $classRoom,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'assistant' => $assistant,
                'class_index' => $classIndex,
            ]);
        } catch ( Exception $exception ) {
            return false;
        }
    }
    
}