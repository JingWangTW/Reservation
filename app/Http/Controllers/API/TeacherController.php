<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use App\Models\ClassManager as ClassManager;
use App\Models\Account as Account;
use App\Models\Reservation as Reservation;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function createClass ( Request $request )
    {
        if ( isset($_POST["className"]) && isset($_POST['academicYear']) && isset($_POST['semester']) )
        {
            if ( ClassManager::createClass($_POST["className"], $_POST["academicYear"], $_POST["semester"] ) )
            {
                return redirect()->route('teacher_home');
            }
            else
            {
               return view('page.utility.wrong_message', ['message' => 'Fail to New Class']);
            }
        }
        else
        {
            return view('page.utility.wrong_message', ['message' => 'Wrong Input']);
        }
    }
    
    public function addStudents ( Request $request )
    {
        if ( isset($_POST["className"]) )
        {
            $studentList = [];
                        
            // if input by file
            if ( isset($_FILES["studentFile"]) && $_FILES["studentFile"]["size"])
            {
                $file = fopen($_FILES["studentFile"]["tmp_name"], "r");
                
                $index = 0;
                
                while (($data = fgetcsv($file)) !== FALSE)
                {
                    // the first row should be title
                    if ($index++ == 0)
                    {
                        if ($data[0] != "StudentName" || $data[1] != "StudentID")
                        {
                            $studentList = null;
                            break;
                        }
                        else
                            continue;
                    }
                    
                    // check if the blank is not empty
                    if ( !empty($data[0]) && !empty($data[1]) && !empty($data[2]) && !empty($data[3]) ) {
                        array_push($studentList, [
                            "studentName" => $data[0],
                            "studentID" => $data[1],
                            "department" => $data[2],
                            "grade" => $data[3],
                        ]);
                    }                    
                }
            }
            // otherwise add by table
            else if ( isset ($_POST["studentName"]) )
            { 
                try 
                {
                    $studentList = [];
                
                    for ($index = 0; $index < count($_POST["studentName"]) ; $index++) 
                    {
                        array_push($studentList, [
                            "studentName" => $_POST["studentName"][$index],
                            "studentID" => $_POST["studentID"][$index],
                            "department" => $_POST["department"][$index],
                            "grade" => $_POST["grade"][$index]
                        ]);
                    }
                }
                catch( Exception $e)
                {
                    return view('page.utility.wrong_message', ['message' => 'Wrong Input']);
                }
            }
            
            if ($studentList != null) 
            {
                $addStudentStatus = Account::addStudents($studentList);
                
                if ( !$addStudentStatus )
                    view('page.utility.wrong_message', ['message' => 'Wrong Input']);
            
                $addToClass = ClassManager::addStudent($_POST['className'], $studentList);
                
                if ( is_array($addToClass) )
                    return view('page.utility.wrong_message', ['message' => json_encode($addToClass)]);
                else
                    return redirect()->route('teacher_home');
            }
            else
            {
                return view('page.utility.wrong_message', ['message' => 'Wrong Input!']);
            }
            
        }
        else
        {
            return view('page.utility.wrong_message', ['message' => 'Wrong Input']);
        }
    }
    
    public function addAssistant ( Request $request )
    {
        if ( isset( $_POST['name'] ) && isset( $_POST['email'] ) )
        {
            $status = Account::addAssistant($_POST['name'], $_POST['email']);
            
            if ( is_array($status) ) {
                
                return view('page.utility.wrong_message', ['message' => json_encode($status)]);
                
            } else {
                
                return redirect()->route('teacher_home');
                
            }
        }
        
        return view('page.utility.wrong_message', ['message' => 'Wrong Input']);
    }
    
    public function addTeacher ( Request $request )
    {
        if ( isset( $_POST['name'] ) && isset( $_POST['email'] ) && isset( $_POST['account'] ) )
        {
            $status = Account::addTeacher($_POST['name'], $_POST['email'], $_POST['account']);
            
            if ( is_array($status) ) {
                
                return view('page.utility.wrong_message', ['message' => json_encode($status)]);
                
            } else {
                
                return redirect()->route('teacher_home');
                
            }
        }
        
        return view('page.utility.wrong_message', ['message' => 'Wrong Input']);
    }
    
    
    public function addReservationClass ( Request $request )
    {
        if ( isset( $_POST['className'] ) && 
             isset( $_POST['classRoom'] ) && 
             isset( $_POST['startTime'] ) && 
             isset( $_POST['endTime'] ) && 
             isset( $_POST['repeatDay'] ) && 
             isset( $_POST['repeatTime'] ) && 
             isset( $_POST['assistant'] ))
        {
            $startTime = $_POST['startTime'][0].' '.$_POST['startTime'][1];
            $endTime = $_POST['endTime'][0].' '.$_POST['endTime'][1];
            
            return Reservation::createReservation($_POST['className'], $_POST['classRoom'], $startTime, $endTime, $_POST['assistant'], $_POST['repeatDay'], $_POST['repeatTime']) ? redirect()->route('teacher_home') : view('page.utility.wrong_message', ['message' => 'Wrong Input']);
        }
        
        return view('page.utility.wrong_message', ['message' => 'Wrong Input']);
    }
    
    public function editReservationClass ( Request $request )
    {
        if ( isset( $_POST['classIndex'] ) && 
             isset( $_POST['className'] ) && 
             isset( $_POST['classRoom'] ) && 
             isset( $_POST['startTime'] ) && 
             isset( $_POST['endTime'] ) && 
             isset( $_POST['assistant'] ))
        {
            $startTime = $_POST['startTime'][0].' '.$_POST['startTime'][1];
            $endTime = $_POST['endTime'][0].' '.$_POST['endTime'][1];
            
            return Reservation::editReservation($_POST['classIndex'], $_POST['className'], $_POST['classRoom'], $startTime, $endTime, $_POST['assistant']) ? redirect()->route('schedule') : view('page.utility.wrong_message', ['message' => 'Wrong Input']);
        }
        
        return view('page.utility.wrong_message', ['message' => 'Wrong Input']);
    }
    
    public function deleteReservationClass ( Request $request )
    {
        if ( isset( $_POST['classIndex'] ) )
        {
            //$status = Reservation::deleteReservation($_POST['classIndex']);
            //return view('page.utility.wrong_message', ['message' => json_encode($status)]);
            return Reservation::deleteReservation($_POST['classIndex']) ? redirect()->route('schedule') : view('page.utility.wrong_message', ['message' => 'Fail']);
        }
        
        return view('page.utility.wrong_message', ['message' => 'Wrong Input']);
    }
    
    
}