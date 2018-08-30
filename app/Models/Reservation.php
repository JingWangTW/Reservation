<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateInterval;

class Reservation extends Model
{
    public static function createReservation ( $className, $classRoom, $startTime, $endTime, $assistant )
    {
        try
        {
            $index = "A".time().mt_rand();
            
            return DB::table('reservation_class')->insert([
                'class_name' => $className,
                'class_room' => $classRoom,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'assistant' => $assistant,
                'class_index' => $index,
            ]);
        } catch ( Exception $exception ) {
            return false;
        }
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
                        'reservation_class.assistant as assistant_index',
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
    
    // get the whole info of class, include student name, student email, questions. 
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
                        -> where ( 'reservation_record.class_index', ">=", $classIndex );
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