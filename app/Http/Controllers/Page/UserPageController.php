<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

use App\Models\Reservation as Reservation;
use App\Models\Account as Account;

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
    
    public function forgetPassword( Request $request )
    {
        return view('page.user.forget');
    }
    
    public function verifyMail( Request $request, $token )
    {
        $status = Account::verifyMail( $token );
        //return $status;
        if ( !is_array($status) ) {
            return view('page.user.reset_password', ['token' => $token]);
        } else {
            return view('page.utility.wrong_message', ['message' => $status['error']]);
        }
    }
}