<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use App\Models\ClassManager as ClassManager;
use App\Models\Account as Account;

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
                        
            if ( isset($_FILES["studentFile"]) && $_FILES["studentFile"]["size"])
            {
                $file = fopen($_FILES["studentFile"]["tmp_name"], "r");
                
                $index = 0;
                
                while (($data = fgetcsv($file)) !== FALSE)
                {
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
                    
                    array_push($studentList, [
                        "studentName" => $data[0],
                        "studentID" => $data[1],
                    ]);
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
                return Account::addStudents($studentList) ? redirect()->route('teacher_home') : view('page.utility.wrong_message', ['message' => '欄位填寫錯誤']);
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
    
    
}