<?php

namespace App\Http\Middleware\Page;

use Closure;

class Warn
{
    public function handle($request, Closure $next)
    {
        // success part
        if (!strcasecmp($request->session()->get('agree', 'false'), "true")) {
            view()->share('AGREE', true);

            // request for welcome, turn it to home
            if ($request->path() == "/")
                return redirect()->route('home');
            else
                return $next($request);
        }
        // unsuccess but is request for welcome page
        else if ($request->path() == "/") {
            view()->share('AGREE', false);
            return view("page.user.welcome");
        } else {
            view()->share('AGREE', false);
            return redirect()->route('welcome');
        }
    }
}