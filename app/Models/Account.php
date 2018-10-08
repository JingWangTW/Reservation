<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Account extends Model
{
    public static function login ( $account, $password )
    {
        $findAccount = DB::table("account")
                        ->where("account", "=", $account)
                        ->first();
            
        if ($findAccount)
        {
            if (  password_verify ($password, $findAccount -> password) )
            {
                $token = Account::generateToken();
                
                $findUser = User::find($account);
                
                if ( !is_null($findUser) )
                {
                    $findUser->token = $token;
                    $findUser->save();
                }
                else
                {
                    User::create([
                        'token' => $token,
                        'id' => $account,
                        'name' => $findAccount -> name,
                        'authority' => $findAccount -> authority,
                    ]);
                }
                                    
                return ['token' => $token, 'authority' => $findAccount -> authority];
            }
            else
            {
                return false;
            }
        }
        
        return false;
    }
    
    public static function logout ( $token )
    {
        // may have logged out
        try {
            
            $findToken = User::where('token', $token)->first();
            
            if ( $findToken )
                $findToken->delete(); 
            
        } catch (\Exception $e) {
            // if the account have been logged out
            // do nothing
        }
    }
    
    public static function sendForgetMail ( $email )
    {
        try 
        {
            $user = DB::table("account")
                ->where("email", "=", $email)
                ->first();
            
            if ( !is_null($user) ) {
                
                $token = Utility::generateRandomString(32);
                
                DB::table("forget_pwd_token")->insert([
                            'token' => $token,
                            'account' => $user->account,
                            'create_at' => date('Y-m-d H:i'),
                        ]);
                
                $content = 'Please click the link below in 30 minutes to change your password.';
                $content = $content."http://140.121.197.130:8106/verifyMail/$token";
                
                Mail::raw($content, function ($message) use ($email) {
                    $message->subject('[Reservation System] Forget Password');
                    $message->to($email);
                });
            }
        }
        catch ( \Exception $e )
        {
            
        }
    }
    
    // use for forget password
    public static function resetPassword ( $token, $newPwd ) {
        
        $user = DB::table("forget_pwd_token")
            -> where("token", "=", $token)
            -> first();
        
        if ( !is_null($user) ) {
            
            if ( abs(time() - strtotime($user->create_at)) < 60 * 30 ) {
                
                DB::table('account')
                    -> where ('account', '=', $user->account)
                    -> update([
                            'password' =>  password_hash($newPwd, PASSWORD_BCRYPT),
                        ]);
                    
                DB::table('forget_pwd_token')
                    -> where("token", "=", $token)
                    -> delete();
                    
                return true;
                
            } else {
                return ['error' => "Over Time!!"];
            }
        }
        
        return ['error' => "Invalid Token!!"];
    }
    
    public static function changePassword ( $user, $oPassword, $password ) {
        
        $userData = DB::table('account')
                    -> where("account", "=", $user->id)
                    -> first();
                    
        if ( password_verify ($oPassword, $userData -> password) ) {
            
            DB::table('account')
                -> where ('account', '=', $userData->account)
                -> update([
                        'password' =>  password_hash($password, PASSWORD_BCRYPT),
                    ]);
                
            return true;
            
        } else {
            return ['error' => "Wrong Password!!"];
        }
        
        return ['error' => "Invalid Token!!"];
    }
    
    public static function verifyMail ( $token ) {
        
        $user = DB::table("forget_pwd_token")
            ->where("token", "=", $token)
            ->first();
        
        if ( !is_null($user) ) {
            
            if ( abs(time() - strtotime($user->create_at)) < 60 * 30 ) {
                return true;
            } else {
                return ['error' => "Over Time!!"];
            }
        }
        
        return ['error' => "Invalid Token!!"];
        
    }
    
    public static function addStudents ( $studentList )
    {
        try
        {
            foreach( $studentList as $student )
            {
                // check if find the exist student
                $findAccount = DB::table("account")
                            ->where("account", "=", $student["studentID"])
                            ->first();
                
                // only insert the student that didn't exist in the database
                if ( is_null($findAccount) )
                {
                    DB::table("account")->insert([
                            "account" => strlen(trim($student["studentID"])) == 0 ? null : $student["studentID"],
                            "password" => password_hash($student["studentID"], PASSWORD_BCRYPT),
                            "name" => $student["studentName"],
                            "authority" => 1,
                            "email" => $student['studentID']."@mail.ntou.edu.tw" ,
                            "department" => $student['department'],
                            "grade" => $student['grade']
                        ]);
                }
            }
            return true;
        }
        catch ( \Exception $exception )
        {
            return ['error' => 'Wrong Input!!!'];
        }
    }
    
    public static function getStudentData( $id ) {
        
        try
        {
            return DB::table("account")
                -> where ( 'account', '=', $id)
                -> where ( 'authority', '=', 1)
                -> select ( 'department', 'grade' )
                -> first ();                
        }
        catch( \Exception $e )
        {
            return ['error' => 'Wrong Input !!!@'];
        }
    }
    
    public static function studentEditProfile( $id, $name, $department, $grade ) {
        
        try
        {
            DB::table("account")
                -> where ( 'account', '=', $id)
                -> update([
                        'name' => $name,
                        'department' => $department,
                        'grade' => $grade,
                    ]);
                
            return true;
        }
        catch( \Exception $e )
        {
            return ['error' => 'Wrong Input !!!@'];
        }
        
    }
    
    public static function assistantEditProfile( $id, $name, $department, $grade, $talent, $subject, $ability, $img ) {
        
        try
        {
            // update account table
            DB::table("account")
                -> where ( 'account', '=', $id)
                -> update([
                        'name' => $name,
                        'department' => $department,
                        'grade' => $grade,
                    ]);
            
            // prepare move file
            $target_file = NULL;
            $file_name = NULL;

            if ( !is_null($img) )
            {
                $target_file = SITE_ROOT."/file/img/$id-profile.".pathinfo($img["name"], PATHINFO_EXTENSION);;
                $file_name = "$id-profile.".pathinfo($img["name"], PATHINFO_EXTENSION);;
            }
           
            $origin_file = DB::table("assistant_profile")
                -> where ( 'assistant_index', '=', $id )
                -> select ('img')
                -> first()
                -> img;

            // update assistant_profile table
            DB::table("assistant_profile")
                -> where ( 'assistant_index', '=', $id)
                -> update([
                        'subject' => $subject,
                        'talent' => $talent,
                        'ability' => $ability,
                        'img' => is_null($img) ? $origin_file : $file_name,
                    ]);
            
            // move file
            if ( $target_file )
                move_uploaded_file($img['tmp_name'], $target_file);
            
            // update user table 
            $findUser = User::find( \Auth::user() -> id);
            $findUser -> name = $name;
            $findUser -> save();


            return true;
        }
        catch( \Exception $e )
        {
            return ['error' => $e -> getMessage()];
            return ['error' => 'Wrong Input !!!@'];
        }
        
    }

    public static function addAssistant ( $name, $email )
    {
        $findAccount = DB::table("account")
                    ->where("account", "=", $email)
                    ->first();
        
        // check is find the smae account
        if ( is_null($findAccount) )
        {
            DB::table("account")
                ->insert([
                    "account" => $email,
                    "password" => password_hash($email, PASSWORD_BCRYPT),
                    "name" => $name,
                    "authority" => 2,
                    "email" => $email 
                ]);
                
            DB::table("assistant_profile")
                ->insert([
                    "assistant_index" => $email,
                ]);
                
            return true;
        } else {
            return ['error' => "Assistant has been registered."];
        }
    }
    
    public static function addTeacher ( $name, $email, $account )
    {
        $findAccount = DB::table("account")
                    ->where("account", "=", $account)
                    ->first();
        
        // check if find the smae account
        if ( is_null($findAccount) )
        {
            return DB::table("account")
                ->insert([
                    "account" => $account,
                    "password" => password_hash($account, PASSWORD_BCRYPT),
                    "name" => $name,
                    "authority" => 3,
                    "email" => $email 
                ]);
        } else {
            return ['error' => "This account has been used."];
        }
        
    }
    
    public static function getAssistantList ()
    {
        $findAssistant = DB::table("account")
                    ->where("authority", "=", 2)
                    ->get();
        
        $assistantList = [];
        
        foreach( $findAssistant as  $assistant )
        {
            array_push ( $assistantList, [
                "name" => "{$assistant -> name}",
                "account" => $assistant -> account,
            ]);
        }
        
        return $assistantList;
    }
    
    public static function getAssistant ( $id )
    {
        $findAssistant = DB::table("assistant_profile")
            -> join('account', function ($join) use ($id){
                    
                    $join->on('account.account', '=', 'assistant_profile.assistant_index')
                        -> where("authority", "=", 2)
                        -> where("account.account", "=", $id);
                })
            -> select(
                    'account.name as name',
                    'account.department as department',
                    'account.grade as grade',
                    'assistant_profile.*'
                )
            -> first();
        
        return $findAssistant;
    }
    
    
    private static function generateToken () {
        $pieces = [];
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < 64; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
    

}
