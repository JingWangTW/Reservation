<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

use App\Models\Reservation as Reservation;

class StudentPageController extends Controller
{
    public function home ( Request $request )
    {
        $classList =  Reservation::get2WeeksReservationClass();
        
        return view('page.student.home', ['classList' => $classList]);
    }
    
    public function changePassword ( Request $request )
    {
        return view('page.student.change_password');
    }
    
}