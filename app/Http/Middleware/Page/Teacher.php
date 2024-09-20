<?php

namespace App\Http\Middleware\Page;

use Closure;

class Teacher
{
    public function handle($request, Closure $next)
    {
        // success part
        if ($request->user()->authority == 3) {
            return $next($request);
        } else {
            return redirect()->route('home');
        }
    }
}