<?php
namespace App\Http\Controllers\FileManager;

use App\Http\Controllers\Controller as Controller;

use Illuminate\Http\Request;

class FileManager extends Controller
{
    public function systemFile(Request $request, $fileName)
    {
        return response()->download(SITE_ROOT . "/file/system/$fileName");
    }

    public function imgFile(Request $request, $fileName = null)
    {
        if (!is_null($fileName) && file_exists(SITE_ROOT . "/file/img/" . $fileName)) {
            return response()->download(SITE_ROOT . "/file/img/" . $fileName);
        } else {
            return response()->download(SITE_ROOT . "/file/img/profile.png");
        }
    }
}
