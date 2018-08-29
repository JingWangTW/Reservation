<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

use App\Models\Reservation as Reservation;

class UserPageController extends Controller
{
    public function index ( Request $request )
    {
        return view('page.user.welcome');
    }
    
    public function home ( Request $request)
    {
        $classList =  Reservation::get2WeeksReservationClass();
        
        return view('page.user.home', ['classList' => $classList]);
    }
    
     
    public function service( Request $request )
    {
        
    }
}