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
                
                $findUser = User::where('account', $account)->first();
                
                if ( $findUser )
                {
                    $findUser->token = $token;
                    $findUser->save();
                }
                else
                {
                    User::create([
                        'token' => $token,
                        'account' => $account,
                        'name' => $findAccount -> name,
                        'authority' => $findAccount -> authority,
                    ]);
                }
                                    
                return ['token' => $token, 'authority' => $findAccount -> authority];//$token;
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
        User::where('token', $token)->first()->delete();
    }
    
    public static function addStudents ( $studentList )
    {
        foreach( $studentList as $student )
        {
            $findAccount = DB::table("account")
                        ->where("account", "=", $student["studentID"])
                        ->where("authority", "=", 1)
                        ->first();
                        
            if ( !$findAccount )
            {
                return DB::table("account")
                    ->insert([
                        "account" => $student["studentID"],
                        "password" => password_hash($student["studentID"], PASSWORD_BCRYPT),
                        "name" => $student["studentName"],
                        "authority" => 1,
                        "email" => $student['studentID']."@mail.ntou.edu.tw" 
                    ]);
            }
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