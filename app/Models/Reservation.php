<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateInterval;

class Reservation extends Model
{
    public static function createReservation ( $className, $classRoom, $startTime, $endTime, $assistant, $repeatDay, $repeatTime )
    {
        // totle times to repeat
        $repeatTime = $repeatTime + 1;
        
        // if repeat every 0 day, jsut add it once
        if ($repeatDay == 0)
            $repeatTime = 1;
        
        for ( $counter = 0; $counter < $repeatTime; $counter++ )
        {
            $index = "A".Utility::generateRandomString(10);
            
            $newStartTime = $startTime;
            $newEndTime = $endTime;
            
            // if the counter larger than 0, change start time and end time
            if ($counter > 0)
            {
                $newStartTime = new DateTime($startTime);
                $newStartTime = $newStartTime -> add(new DateInterval('P'.$repeatDay*$counter.'D'));
                
                $newEndTime = new DateTime($endTime);
                $newEndTime = $newEndTime -> add(new DateInterval('P'.$repeatDay*$counter.'D'));
            }
            
            try
            {
                DB::table('reservation_class')->insert([
                    'class_name' => $className,
                    'class_room' => $classRoom,
                    'start_time' => $newStartTime,
                    'end_time' => $newEndTime,
                    'assistant' => $assistant,
                    'class_index' => $index
                ]);                     
            } 
            catch( Exception $exception )
            {
                return false;
            }
        }
        
        return true;
    }
    
    public static function get2WeeksReservationClass () 
    {
        // query builder
        $classList = DB::table('reservation_class')
            ->join('account', function( $join )         // join the account table, to get the name of assistant
                {
                    // set the date limit to query
                    $currentDate = date('Y-m-d');
                    $lastDate = new DateTime();
                    $lastDate = $lastDate -> add(new DateInterval('P2W'))
                                            -> format('Y-m-d');
                    
                    // condition to join table
                    $join->on('reservation_class.assistant', '=', 'account.account')
                        -> where ( 'reservation_class.start_time', ">=", $currentDate )
                        -> where ( 'reservation_class.end_time', "<", $lastDate )
                        -> orderBy('start_time', 'asec');
                })
            // only selest the column that need
            -> select ( 'reservation_class.class_index', 
                        'reservation_class.class_name', 
                        'reservation_class.class_room', 
                        'reservation_class.start_time', 
                        'reservation_class.end_time', 
                        'account.name as assistant_name') ->get();
        
        return $classList;
    }
    
    public static function getFutureAllClass ()
    {
        // query builder
        $classList = DB::table('reservation_class')
            ->join('account', function( $join )         // join the account table, to get the name of assistant
                {
                    // set the date limit to query
                    $currentDate = date('Y-m-d');
                    
                    // condition to join table
                    $join->on('reservation_class.assistant', '=', 'account.account')
                        -> where ( 'reservation_class.start_time', ">=", $currentDate )
                        -> orderBy('start_time', 'asec');
                })
            // only selest the column that need
            -> select ( 'reservation_class.class_index', 
                        'reservation_class.class_name', 
                        'reservation_class.class_room', 
                        'reservation_class.start_time', 
                        'reservation_class.end_time', 
                        'account.name as assistant_name') ->get();
        
        return $classList;
    }
    
    public static function studentMakingReservation ( $classIndex, $question, $userAccount )
    {
        // insert reservation record to db
        try
        {
            return DB::table('reservation_record')->insert([
                'class_index' => $classIndex,
                'question' => $question = "" ? NULL : $question,
                'student_account' => $userAccount
            ]);
            
        } catch ( Exception $exception ) {
            return false;
        }
    }
    
    public static function getClassListByAssistant ( $assistant )
    {
        // query builder
        $classList = DB::table('reservation_class')
            -> where ( 'assistant',  '=', $assistant )
            -> get();
        
        return $classList;
    }
    
    // get only info in reservation_class table
    public static function getClassInfo ( $classIndex )
    {
        $classList = DB::table('reservation_class')
            -> where ( 'class_index',  '=', $classIndex )
            -> first();
            
        return $classList;
    }
    
    // get the whole info of class, include student name, student email, questions, etc. 
    public static function getClass ( $classIndex )
    {
        // get the class info
        $classInfo = Reservation::getClassInfo( $classIndex );
            
        // get all student info
        $studentInfo = DB::table('reservation_record')
            // join the account table, to get the info of assistant
            ->join('account', function( $join ) use ($classIndex)
                {
                    // condition to join table
                    $join->on('reservation_record.student_account', '=', 'account.account')
                        -> where ( 'reservation_record.class_index', "=", $classIndex );
                })
            // only selest the column that need
            -> select ( 'reservation_record.question', 
                        'account.account as student_id', 
                        'account.name', 
                        'account.department',
                        'account.grade'
                        ) 
            ->get();
        
        $classInfo->student = $studentInfo;
            
            /*
            // only selest the column that need
            -> select ( 'reservation_class.class_index', 
                        'reservation_class.class_name', 
                        'reservation_class.class_room', 
                        'reservation_class.start_time', 
                        'reservation_class.end_time', 
                        'reservation_class.assistant as assistant_index',
                        'account.name as assistant_name') ->get();
                        */
        
        return (array)$classInfo;
    }
    
}