<?php

namespace App\Http\Middleware\Page;

use Closure;

class Student
{
    public function handle($request, Closure $next)
    {
        // success part
        if ( $request -> user() -> authority == 1 )
        {
            return $next($request);
        }
        else
        {
            return  redirect()->route('home');
        }
    }
}