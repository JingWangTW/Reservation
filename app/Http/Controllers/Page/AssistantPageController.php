<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

use App\Models\Reservation as Reservation;
use App\Models\Account as Account;

class AssistantPageController extends Controller
{
    public function home ( Request $request )
    {
        $classList = Reservation::getReservationClassList([
            ['assistant', '=', \Auth::user() -> id],
            ['start_time', '>=', date('Y-m-d')],
        ]);
        
        return view('page.assistant.home', ['classList' => $classList]);
    }
    
    public function classOverview ( Request $request )
    {
        $classInfo = Reservation::getClass( route_parameter('class_index') );
        
        return view('page.assistant.class_overview', ['classInfo' => $classInfo]);
    }
    
    public function editProfile ( Request $request ) 
    {
        $assistant = Account::getAssistant( \Auth::user()->id );
        
        return view('page.assistant.edit_profile', ['assistant' => $assistant]);
    }
    
    public function changePassword ( Request $request )
    {
        return view('page.assistant.change_password');
    }
    
}