<?php

namespace App\Http\Middleware\Page;

use Closure;

class Assistant
{
    public function handle($request, Closure $next)
    {
        // success part
        if ( $request -> user() -> authority == 2 )
        {
            return $next($request);
        }
        else
        {
            return  redirect()->route('home');
        }
    }
}