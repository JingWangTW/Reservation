<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

use App\Models\Reservation as Reservation;

class AssistantPageController extends Controller
{
    public function home ( Request $request )
    {
        $classList = Reservation::getReservationClassList([
            ['assistant', '=', \Auth::user() -> id]
        ]);
        
        return view('page.assistant.home', ['classList' => $classList]);
    }
    
    public function classOverview ( Request $request )
    {
        $classInfo = Reservation::getClass( route_parameter('class_index') );
        
        return view('page.assistant.class_overview', ['classInfo' => $classInfo]);
    }
    
    public function changePassword ( Request $request )
    {
        return view('page.assistant.change_password');
    }
    
}