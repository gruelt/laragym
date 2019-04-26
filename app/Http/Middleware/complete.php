<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\User;


/*
 * Checks If the account is fully filled
 */
class complete
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if($this->auth->user()) {

            $id = $this->auth->user()->id;
        }
        if(User::find($id)->complete == 0 ) {
            return redirect('/formcomplete')->withErrors("Informations incomplètes $id pour/" . $request->path());
        }
        else{
            return $next($request);
        }
    }
}
