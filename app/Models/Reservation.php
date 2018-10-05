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
            catch( \Exception $exception )
            {
                return ['error' => 'wrong Input!!!@'];
            }
        }
        
        return true;
    }
    
    public static function editReservation ( $classIndex, $className, $classRoom, $startTime, $endTime, $assistant )
    {
        try
        {
            DB::table('reservation_class')
                -> where ('class_index', '=', $classIndex)
                -> update([
                        'class_name' => $className,
                        'class_room' => $classRoom,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'assistant' => $assistant
                    ]); 
            return true;
        } 
        catch( \Exception $exception )
        {
            return ['error' => 'wrong Input!!!@'];
        }
    }
    
    public static function deleteReservation ( $classIndex )
    {
        try
        {
            return DB::table('reservation_class')
                -> where ('class_index', '=', $classIndex)
                -> delete()  ;
        } 
        catch( \Exception $exception )
        {
            return false;
        }
    }
    
    public static function getReservationClassList ( $query )
    {
        // SELECT class_index, haha.cnttt, class_name from `reservation_class`, (SELECT class_index as bang, count(class_index) as cnttt from `reservation_record` group by `class_index`) as haha where reservation_class.class_index = bang
        $record = DB::table( 'reservation_record' )
           -> select( 'reservation_record.class_index', DB::raw('count(reservation_record.class_index) as people_amount') )
           -> groupBy ('reservation_record.class_index')
           -> get()
           -> toArray();
        
        $classList = DB::table('reservation_class')
            -> join('account', function( $join ) use ($query)  // join the account table, to get the name of assistant
                {
                    // condition to join table
                    $join->on('reservation_class.assistant', '=', 'account.account')
                        -> where ( $query );
                })
            // only selest the column that need
            -> select ( 'reservation_class.*', 
                        'account.name as assistant_name')
            -> orderBy ('reservation_class.start_time', 'asc')
            -> get();
        
        // manually join
        foreach( $classList as $key => $class ) {
            
            $find = array_search($class->class_index, array_column($record, 'class_index'));
            
            if ( $find !== false )
            {
                $classList[$key]->people_amount = $record[$find]->people_amount;
            }
            else 
            {
                $classList[$key]->people_amount = 0;
            }
        }
            
        return $classList;
    }
    
    public static function getReservationRecord ( $userId )
    {
        // query builder
        $classList = DB::table('reservation_record')
            ->join('reservation_class', function( $join ) use ($userId)   // join the account table, to get the name of assistant
                {
                    // condition to join table
                    $join->on('reservation_class.class_index', '=', 'reservation_record.class_index')
                        -> where ( 'student_account', '=', $userId )
                        -> where ( 'reservation_class.start_time', '>=', date('Y-m-d') );
                })
            // only selest the column that need
            -> select ( 'reservation_class.class_index',
                        'question' )
            -> orderBy ('reservation_class.start_time', 'asc')
            -> get();
            
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
            
        } catch ( \Exception $exception ) {
            return false;
        }
    }
    
    public static function editRecord ( $classIndex, $question, $userId )
    {
        // insert reservation record to db
        try
        {
            $classData = (array)DB::table('reservation_class')
                -> where ('class_index', '=', $classIndex)
                -> first();
            
            $startTime = new DateTime($classData['start_time']);
            $current = new DateTime();
            
            // check if in the editable duration
            if ($startTime->getTimeStamp() - $current->getTimeStamp() > 2*60 ) {
                return DB::table('reservation_record')
                    -> where ('class_index', '=', $classIndex)
                    -> where ('student_account', '=', $userId)
                    -> update([
                            'question' => $question
                        ]);
            } else {
                return ['error' => 'Not in editable duration'];
            }
            
            
        } catch ( \Exception $exception ) {
            return ['error' => 'Wrong Input'];
        }
    }
    
    public static function deleteRecord ( $classIndex, $userId )
    {
        // insert reservation record to db
        try
        {
            $classData = (array)DB::table('reservation_class')
                -> where ('class_index', '=', $classIndex)
                -> first();
                
            $startTime = new DateTime($classData['start_time']);
            $current = new DateTime();
            
            // check if in the editable duration
            if ($startTime->getTimeStamp() - $current->getTimeStamp() > 2*60 ) {
                return DB::table('reservation_record')
                    -> where ('class_index', '=', $classIndex)
                    -> where ('student_account', '=', $userId)
                    -> delete();
            } else {
                return ['error' => 'Not in editable duration'];
            }
            
        } catch ( \Exception $exception ) {
            return ['error' => 'Wrong Input'];
        }
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
        
        return (array)$classInfo;
    }
    
}
