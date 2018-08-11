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
            $checkSuccess = false;
            
            // check if exist upload file
            if ( isset($_POST["studentFile"]) && $_POST["studentFile"])
            {
                return "789";
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
                
                $checkSuccess =  Account::addStudents($studentList);
                
                if ($checkSuccess )
                    return "1";
                else
                    return "2";
            }
        }
        else
        {
            return view('page.utility.wrong_message', ['message' => '欄位填寫錯誤']);
        }
    }
    
    
}