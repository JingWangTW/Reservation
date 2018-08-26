<?php

namespace App\Http\Controllers\Page;

use App\Models\ClassManager as ClassManager;
use App\Models\Account as Account;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class TeacherPageController extends Controller
{
    public function home ( Request $request )
    {
        return view('page.teacher.home');
    }
    
    public function createClass ( Request $request )
    {
        return view('page.teacher.create_class');
    }
    
    public function addStudents ( Request $request)
    {
        $classList = ClassManager::getClassList();
        
        return view('page.teacher.add_students', ['classList' => $classList]);
    }
    
    public function addAssistant ( Request $request)
    {
        return view('page.teacher.add_assistant');
    }
    
    public function addReservation ( Request $request)
    {
        $assistantList = Account::getAssistantList();
        
        return view('page.teacher.add_reservation', ['assistantList' => $assistantList]);
    }
    
}