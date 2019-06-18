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

        print_r($_SERVER['HTTP_USER_AGENT']);


	return $next($request);
    }
}
