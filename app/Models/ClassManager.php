<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClassManager extends Model
{
    public static function createClass ( $className, $academicYear, $semester )
    {
        $index = "C".time().mt_rand();
        try
        {
            return DB::table('class')->insert([
                'class_name' => $className,
                'academic_year' => $academicYear,
                'semester' => $semester,
                'class_index' => $index
            ]);
        } catch ( Exception $exception ) {
            return false;
        }
    }
    
    public static function addStudent ( $classIndex, $studentList )
    {
        try 
        {
            foreach ( $studentList as $student )
            {
                DB::table('class_own_student') -> insert([
                    'class_index' => $classIndex,
                    'account' => $student["studentID"]
                ]);
            }
            
            return true;
            
        } catch ( Exception $exception ) {
            return false;
        }
    }
    
    public static function getClassList (  )
    {
        $class = DB::table('class')->get();
        $classList = [];
        
        foreach( $class as  $singleClass)
        {
            array_push ( $classList, [
                "className" => "{$singleClass -> academic_year}{$singleClass -> semester} {$singleClass -> class_name}",
                "classIndex" => $singleClass -> class_index,
            ]);
        }
        
        return $classList;
    }
}