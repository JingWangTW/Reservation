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
            // check if login success
            if ( $info = Account::login($_POST["account"], $_POST["password"]) )
            {
                $request->session()->put("token", $info['token']);
                
                // return to home after login
                return redirect()->route('home');
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
    
    public function logout ( Request $request )
    {
        Account::logout( $request->session()->get("token") );
        $request->session()->pull("token");
        $request->session()->pull("agree");
        
        return redirect()->route('home');
    }
    
    public function forgetPwd ( Request $request )
    {
        if ( isset($_POST["email"]) )
        {
            Account::sendForgetMail( $_POST["email"] );
            
            return redirect()->route('home');
        }
        else
        {
            return redirect()->route('welcome');
        }
    }
    
    public function resetPwd ( Request $request )
    {
        if ( isset($_POST["password"]) && isset($_POST["token"]) )
        {
            $status = Account::resetPassword( $_POST["token"], $_POST["password"] );
            
            //return $status;
            if ( !is_array($status) ) {
                return redirect()->route('home');
            } else {
                return view('page.utility.wrong_message', ['message' => $status['error']]);
            }
        }
        else
        {
            return redirect()->route('welcome');
        }
    }
}