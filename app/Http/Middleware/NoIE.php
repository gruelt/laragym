<?php

namespace App\Http\Middleware;

use Closure;

class NoIE
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(strstr($_SERVER['HTTP_USER_AGENT'],'Trident'))
        {
            return redirect('/noie');
        }


	return $next($request);
    }
}
