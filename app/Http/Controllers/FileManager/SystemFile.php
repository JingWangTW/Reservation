<?php
namespace App\Http\Controllers\FileManager;

use App\Http\Controllers\Controller as Controller;
use App\Models\Account as Account;

use Illuminate\Http\Request;

class SystemFile extends Controller
{
    public function service ( Request $request, $fileName )
    {
        return response()->download("public/file/system/$fileName");
    }
    
    
}