<?php

namespace App\Http\Middleware\Authorization;

use Closure;

class HomeRedirect
{
    public function handle($request, Closure $next)
    {
        // null user means visitor
        if (is_null($request->user())) {
            return $next($request);
        }
        // student visitor
        else if ($request->user()->authority == 1) {
            return redirect()->route('student_home');
        }
        // assistant visitor
        else if ($request->user()->authority == 2) {
            return redirect()->route('assistant_home');
        }
        // teacher visitor
        else if ($request->user()->authority == 3) {
            return redirect()->route('teacher_home');
        }
    }
}