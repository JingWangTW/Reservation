<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use App\Models\Reservation as Reservation;

use Illuminate\Http\Request;


class StudentController extends Controller
{
    public function makingReservation ( Request $request )
    {
        if ( isset($_POST["classIndex"]) && isset($_POST["question"]) )
        {
            $status = Reservation::studentMakingReservation ($_POST["classIndex"], $_POST["question"], \Auth::user()->id);
            
            if ( $status ) {
                
                return redirect()->route('student_home');
                
            } else {
                
                return view('page.utility.wrong_message', ['message' => 'Wrong Input!']);
                
            }
        }
        else
        {
            return view('page.utility.wrong_message', ['message' => 'Wrong Input!']);
        }
    }
    
    public function editReservation ( Request $request )
    {
        if ( isset($_POST["classIndex"]) && isset($_POST["question"]) )
        {
            $status = Reservation::editRecord ( $_POST["classIndex"], $_POST["question"], \Auth::user()->id);
            
            if ( !is_array($status) ) {
                
                return redirect()->route('student_home');
                
            } else {
                
                return view('page.utility.wrong_message', ['message' => json_encode($status)]);
                
            }
        }
        else
        {
            return view('page.utility.wrong_message', ['message' => 'Wrong Input!']);
        }
    }
    
    public function deleteReservation ( Request $request )
    {
        if ( isset($_POST["classIndex"]) )
        {
            $status = Reservation::deleteRecord ($_POST["classIndex"], \Auth::user()->id);
            
            if ( !is_array($status) ) {
                
                return redirect()->route('student_home');
                
            } else {
                
                return view('page.utility.wrong_message', ['message' => json_encode($status)]);
                
            }
        }
        else
        {
            return view('page.utility.wrong_message', ['message' => 'Wrong Input!']);
        }
    }
    
    
}