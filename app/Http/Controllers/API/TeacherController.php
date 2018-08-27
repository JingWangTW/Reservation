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
            if ( ClassManager::createClass($_POST["className"], $_POST["academicYear"], $_POST["semester"], "C".time().mt_rand() ) )
            {
                return redirect()->route('teacher_home');
            }
            else
            {
               return view('page.utility.wrong_message', ['message' => '新增課程失敗']);
            }
        }
        else
        {
            return view('page.utility.wrong_message', ['message' => '欄位填寫錯誤']);
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
                    if ( !empty($data[0]) && !empty($data[1]) ) {
                        array_push($studentList, [
                            "studentName" => $data[0],
                            "studentID" => $data[1],
                        ]);
                    }                    
                }
            }
            // otherwise add by table
            else if ( isset ($_POST["studentName"]) )
            { 
                $studentList = [];
                
                for ($index = 0; $index < count($_POST["studentName"]) ; $index++) 
                {
                    array_push($studentList, [
                        "studentName" => $_POST["studentName"][$index],
                        "studentID" => $_POST["studentID"][$index]
                    ]);
                }
            }
            
            if ($studentList != null) 
            {
                $addStudentStatus = Account::addStudents($studentList);
                
                if ( !$addStudentStatus )
                    view('page.utility.wrong_message', ['message' => 'Wrong Input']);
            
                $addToClass = ClassManager::addStudent($_POST['className'], $studentList);
                
                if ( !$addToClass )
                    return view('page.utility.wrong_message', ['message' => 'Wrong Input']);
                else
                    return redirect()->route('teacher_home');
            }
            else
            {
                return view('page.utility.wrong_message', ['message' => '欄位填寫錯誤']);
            }
            
        }
        else
        {
            return view('page.utility.wrong_message', ['message' => '欄位填寫錯誤']);
        }
    }
    
    public function addAssistant ( Request $request )
    {
        if ( isset( $_POST['name'] ) && isset( $_POST['email'] ) )
        {
            $status = Account::addAssistant($_POST['name'], $_POST['email']);
            
            if ( is_array($status)  && $status['error'] ) {
                
                return view('page.utility.wrong_message', ['message' => $status['error']]);
                
            } else if ( $status ) {
                
                return redirect()->route('teacher_home');
                
            } else {
                
                return view('page.utility.wrong_message', ['message' => 'Wrong Input!']);
                
            }
        }
        
        return view('page.utility.wrong_message', ['message' => 'Wrong Input']);
    }
    
    public function addReservation ( Request $request )
    {
        if ( isset( $_POST['className'] ) && 
             isset( $_POST['classRoom'] ) && 
             isset( $_POST['startTime'] ) && 
             isset( $_POST['endTime'] ) && 
             isset( $_POST['assistant'] ))
        {
            $index = "A".time().mt_rand();
            
            $startTime = $_POST['startTime'][0].' '.$_POST['startTime'][1];
            $endTime = $_POST['endTime'][0].' '.$_POST['endTime'][1];
            
            return Reservation::createReservation($_POST['className'], $_POST['classRoom'], $startTime, $endTime, $_POST['assistant'], $index) ? redirect()->route('teacher_home') : view('page.utility.wrong_message', ['message' => 'Wrong Input']);
        }
        
        return view('page.utility.wrong_message', ['message' => 'Wrong Input']);
    }
    
    
}