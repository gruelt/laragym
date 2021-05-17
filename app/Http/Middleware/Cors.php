<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        $domain = parse_url($_SERVER['HTTP_REFERER']);
//        $host = '*';
//        if (isset($domain['host'])) {
//            $host = $domain['host'];
//        }

        return $next($request)->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
           -> header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Headers', 'Accept , X-Requested-With, Content-Type, X-Token-Auth, Authorization');

    }
}
