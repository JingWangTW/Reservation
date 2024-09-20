<?php

namespace App\Http\Middleware\Authorization;

use Closure;
use App\Models\Reservation as Reservation;

class Assistant
{
    public function handle($request, Closure $next)
    {
        // success part
        if ($request->user()->authority == 2) {
            $classInfo = Reservation::getClassInfo(route_parameter('class_index'));

            if ($classInfo && $classInfo->assistant == $request->user()->id) {
                return $next($request);
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }
    }
}