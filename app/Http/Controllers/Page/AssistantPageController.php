<?php

namespace App\Http\Controllers\Page;

use App\Models\ClassManager as ClassManager;
use App\Models\Account as Account;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class AssistantPageController extends Controller
{
    public function home ( Request $request )
    {
        return view('page.assistant.home');
    }
    
}