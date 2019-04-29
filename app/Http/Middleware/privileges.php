<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Gestion\General;
use App\Http\Controllers\privilegesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;

/**
 * Middleware droits : recoit en paramètre un droit requis , et continue la requete si on a les droits.
 *    Sinon renvoie sur une vue blade
 */

class privileges
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }




    public function handle($request, Closure $next, ... $DroitRequis)
    {

        /**
         * Récupère l'id en base du droit requis
         */


        $IdDR = new privilegesController;
        foreach ($DroitRequis as $droit)
        {
            $idDroitRequis[] = $IdDR->getPrivilegeId($droit);
        }

        /**
         * Récupère les droits de l'utilisateur en cours
         */
/**
        //récupère l'id dans sesame
        $general=new General;

        //Récupération du current user de laravel auth

        if(!is_null($general->getCurrentUser()))
        {

            $id=$general->getCurrentUser()->id;
        }
        else {
            $id=null;
        }
**/


        //récupére le array des droits dans sesame de l'utilisateur courant


        if($this->auth->user()) {

            $id = $this->auth->user()->id;
        }
        else{
            return redirect('/home')->withErrors("Droits insuffisants pour /".$request->path());
        }


        $IdDR = new PrivilegesController;

        $IdDroitsActifs=$IdDR->getPrivileges($id);

        $possibleDroits=$IdDR->getPossiblePrivileges();


        foreach($IdDroitsActifs as $iddroit )

        {

            $request->session()->put($possibleDroits[$iddroit], 1);
            session()->save();
        }


        $IdDroitsActifs=$IdDR->getPrivileges($id);


        //récupère ses droits
        //if(in_array($idDroitRequis,$IdDroitsActifs))
        if(array_intersect($idDroitRequis,$IdDroitsActifs))
        {
            return $next($request);
        }
        else {
            return back()->withErrors("Droits insuffisants pour /".$request->path());
            //return redirect('/')->withErrors("Droits insuffisants pour /".$request->path());
        }

    }
}
