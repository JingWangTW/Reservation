<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use \DateTime;
use \DateInterval;

use App\Models\Reservation as Reservation;

class StudentPageController extends Controller
{
    public function home ( Request $request )
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
        
        $recordList = Reservation::getReservationRecord( $request -> user()->id );
        
        return view('page.student.home', ['classList' => $classList, 'recordList' => $recordList]);
    }
    
    public function changePassword ( Request $request )
    {
        return view('page.student.change_password');
    }
    
}