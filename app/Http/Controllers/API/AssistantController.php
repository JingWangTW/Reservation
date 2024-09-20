<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

use App\Models\Reservation as Reservation;
use App\Models\Account as Account;

class AssistantController extends Controller
{
    public function editProfile(Request $request)
    {

        if (
            isset($_POST["name"]) && isset($_POST["department"]) && isset($_POST["grade"]) &&
            isset($_POST['talent']) && isset($_POST['subject']) && isset($_POST['ability'])
        ) {
            $status = Account::assistantEditProfile(
                \Auth::user()->id,
                trim($_POST["name"]),
                trim($_POST["department"]),
                trim($_POST["grade"]),
                trim($_POST["talent"]),
                trim($_POST["subject"]),
                trim($_POST['ability']),
                isset($_FILES['img']) && $_FILES['img']['size'] ? $_FILES['img'] : NULL
            );

            if (is_array($status)) {

                return view('page.utility.wrong_message', ['message' => json_encode($status)]);

            } else {

                return redirect()->route('assistant_home');

            }
        } else {
            return view('page.utility.wrong_message', ['message' => 'Wrong Input!']);
        }
    }
}

