<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use App\Model\Account;

use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * 保存一个新用户
     *
     * @param  Request  $request
     * @return Response
     */

    public function signAgreeWarn ( Request $request )
    {
        if ( isset($_POST["agree"]) && !strcasecmp ($_POST["agree"], "agree") )
        {
            $request->session()->put('agree', "true");
            
            return redirect()->route('home');
        }
        else
        {
            return redirect()->route('welcome');
        }
    }
    
    
}