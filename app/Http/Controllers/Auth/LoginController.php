<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use http\Env\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /** Login attempt by api
     * @param Request $request
     * @return Request
     */
    public function apiLogin()
    {
        $token = Auth::attempt(['email' => 'gruelt@gmail.com', 'password' => 'utzshu']);
        return $token;
    }

    /** Login attempt by api
     * @param Request $request
     * @return Request
     */
    public function whoAmI()
    {
        $reponse = Auth::user();
        //dd(Auth::user());

//        $reponse['username']="nobody";

        return $reponse;
    }


}
