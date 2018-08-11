<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class UserPageController extends Controller
{
    /**
     * 保存一个新用户
     *
     * @param  Request  $request
     * @return Response
     */
    public function index ( Request $request )
    {
        return view('page.user.welcome');
    }
    
    public function home ( Request $request)
    {
        return view('page.user.home');
    }
    
     
    public function service( Request $request )
    {
        
    }
}