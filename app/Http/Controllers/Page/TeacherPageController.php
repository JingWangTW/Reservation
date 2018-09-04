<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

use App\Models\ClassManager as ClassManager;
use App\Models\Account as Account;
use App\Models\Reservation as Reservation;


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
    
    public function addStudents ( Request $request )
    {
        $classList = ClassManager::getClassList();
        
        return view('page.teacher.add_students', ['classList' => $classList]);
    }
    
    public function newAssistant ( Request $request )
    {
        return view('page.teacher.new_assistant');
    }
    
    public function newReservation ( Request $request )
    {
        $assistantList = Account::getAssistantList();
        
        return view('page.teacher.new_reservation', ['assistantList' => $assistantList]);
    }
    
    public function schedule ( Request $request )
    {
        // set the date limit to query
        $classList = Reservation::getReservationClassList([
            ['start_time', '>=', date('Y-m-d')]
        ]);
        $assistantList = Account::getAssistantList();
        
        return view('page.teacher.schedule', ['assistantList' => $assistantList, 'classList' => $classList]);
    }
    
    public function classOverview ( Request $request )
    {
        $classInfo = Reservation::getClass( route_parameter('class_index') );
        
        return view('page.teacher.class_overview', ['classInfo' => $classInfo]);
    }
    
    public function changePassword ( Request $request )
    {
        return view('page.teacher.change_password');
    }
}