<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use App\Models\ClassManager as ClassManager;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function createClass ( Request $request )
    {
        if ( isset($_POST["className"]) && isset($_POST['academicYear']) && isset($_POST['semester'])) )
        {
            if ( ClassManager::createClass($_POST["className"], $_POST["academicYear"], $_POST["semester"], "C".time().mt_rand() ) )
            {
                return redirect()->route('teacher_home');
            }
            else
            {
               return view('page.utility.wrong_page', ['message' => '新增課程失敗']);
            }
        }
        else
        {
            return view('page.utility.wrong_page', ['message' => '欄位填寫錯誤']);
        }
        
    }
    
    
}