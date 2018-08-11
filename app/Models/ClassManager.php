<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClassManager extends Model
{
    public static function createClass ( $className, $academicYear, $semester, $classIndex )
    {
        try
        {
            return DB::table('class')->insert([
                'class_name' => $className,
                'academic_year' => $academicYear,
                'semester' => $semester,
                'class_index' => $classIndex
            ]);
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