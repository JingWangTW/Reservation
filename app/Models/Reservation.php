<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    public static function createReservation ( $className, $classRoom, $time, $assistant, $classIndex )
    {
        try
        {
            return DB::table('reservation_class')->insert([
                'class_name' => $className,
                'class_room' => $classRoom,
                'date_time' => $time,
                'assistant' => $assistant,
                'class_index' => $classIndex,
            ]);
        } catch ( Exception $exception ) {
            return false;
        }
    }
    
}