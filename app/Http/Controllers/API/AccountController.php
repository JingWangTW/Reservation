<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use App\Models\Account as Account;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function login ( Request $request )
    {
        
        if ( isset($_POST["account"]) && isset($_POST['password']) )
        {
            if ( $token = Account::login($_POST["account"], $_POST["password"]) )
            {
                $request->session()->put("token", $token);
                
                return redirect()->route('teacher_home');
            }
            else
            {
                return redirect()->route('home');
            }
        }
        else
        {
            return redirect()->route('welcome');
        }
    }
    
    
}