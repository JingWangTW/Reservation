<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

use App\Models\Reservation as Reservation;
use App\Models\Account as Account;

class StudentController extends Controller
{
    public function editProfile ( Request $request )
    {
        if ( isset($_POST["name"]) && isset($_POST["department"]) &&  isset($_POST["grade"]) &&
                strlen(trim(isset($_POST["name"]))) && strlen(trim(isset($_POST["department"]))) &&  strlen(trim(isset($_POST["grade"]))) )
        {
            $status = Account::studentEditProfile ( \Auth::user() -> id, trim($_POST["name"]), trim($_POST["department"]), trim($_POST["grade"]) );
            
            if ( is_array($status) ) {
                
                return view('page.utility.wrong_message', ['message' => json_encode($status)]);
                
            } else {
                
                return redirect()->route('student_home');
                
            }
        }
        else
        {
            return view('page.utility.wrong_message', ['message' => 'Wrong Input!']);
        }
    }
    
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