<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use \DateTime;
use \DateInterval;

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
        // set the date limit to query
        $startTime = date('Y-m-d');
        $endTime = new DateTime();
        $endTime = $endTime -> add(new DateInterval('P2W'))
                                -> format('Y-m-d');
        
        
        $classList =  Reservation::getReservationClassList([
            ['start_time', '>=', $startTime],
            ['end_time', '<', $endTime],            
        ]);
        
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
    
    public function changePassword( Request $request )
    {
        return view('page.user.change_password');
    }
}