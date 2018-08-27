<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
            {return "false";
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
            
        } catch (Exception $e) {
            // if the account have been logged out
            // do nothing
        }
    }
    
    public static function addStudents ( $studentList )
    {
        foreach( $studentList as $student )
        {
            // check if find the exist student
            $findAccount = DB::table("account")
                        ->where("account", "=", $student["studentID"])
                        ->where("authority", "=", 1)
                        ->first();
            
            // only insert the student that didn't exist in the database
            if ( is_null($findAccount) )
            {
                DB::table("account")->insert([
                        "account" => $student["studentID"],
                        "password" => password_hash($student["studentID"], PASSWORD_BCRYPT),
                        "name" => $student["studentName"],
                        "authority" => 1,
                        "email" => $student['studentID']."@mail.ntou.edu.tw" 
                    ]);
            }
        }
    }
    
    public static function addAssistant ( $name, $email )
    {

        $findAccount = DB::table("account")
                    ->where("authority", "=", 1)
                    ->where("account", "=", $email)
                    ->first();
        
        // check is find the smae assistant
        if ( !is_null($findAccount) )
        {
            return DB::table("account")
                ->insert([
                    "account" => $email,
                    "password" => password_hash($email, PASSWORD_BCRYPT),
                    "name" => $name,
                    "authority" => 2,
                    "email" => $email 
                ]);
        } else {
            return ['error' => "Find Same Assistant"];
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