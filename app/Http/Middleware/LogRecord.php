<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Support\Facades\DB;

class LogRecord
{
    /**
     * The following method loops through all request input and strips out all tags from
     * the request. This to ensure that users are unable to set ANY HTML within the form
     * submissions, but also cleans up input.
     *
     * @param Request $request
     * @param callable $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {

        $ip = $request -> ip();
        $action = $request -> path();
        $method = $request -> method();
        $data = null;
        $token = null;
        $account = null;
        
        if ( strpos($action, "login") === false && strpos($action, "signup") === false &&
             strpos($action, "reset_pwd") === false && strpos($action, "change_pwd") === false )
        {
            $data = json_encode($request -> all());
        }

        if ( \Auth::user() && \Auth::user() -> token ) 
        {
            $token = \Auth::user() -> token;
            $account = \Auth::user() -> id;
        }


        DB::table('log')
            -> insert([
                'ip' => $ip,
                'action' => $action,
                'method' => $method,
                'data' => $data,
                'account' => $account,
                'token' => $token,
            ]);

        return $next($request);
    }
}
