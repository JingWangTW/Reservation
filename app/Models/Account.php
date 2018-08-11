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
                                    
                return $token;
            }
            else
            {
                return false;
            }
        }
        
        return false;
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