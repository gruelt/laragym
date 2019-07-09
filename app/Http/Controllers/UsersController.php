<?php

namespace App\Http\Controllers;

use App\Privileges;
use App\Saison;
use App\User;
use Illuminate\Http\Request;

use phpDocumentor\Reflection\Types\Array_;

class UsersController extends Controller
{

    /**
     * Retourne les users avec le profil coach
     * @return array
     */
    public function getcoachspluck()
    {
        $return=array();


        $coachs = Privileges::find(5)->users()->get()->pluck('prenom','id');







        return $coachs;

        //return $gymnastes;
    }

    /**
     * Récupère la liste des responsables par saison
     * @param $saison_id
     * @return mixed
     */
    public function getbyseason($saison_id)
    {
        $return=array();

        if($saison_id == 9999)
        {
            return User::all();
        }

        $gymnastes = Saison::find($saison_id)->gymnastes;

        $done=array();

        foreach($gymnastes as $key => $gymnaste)
        {
            $responsable = $gymnaste->responsable()->first();

            if(!isset($done[$responsable->id]))
            {
                $return[] = $gymnaste->responsable()->first();
                $done[$responsable->id]=1;
            }

        }

        return $return;
    }

    /**
     * Vue pour récuprer le responsable
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showresponsable($user_id)
    {
        $return =array();

        $equipe = User::find($user_id);

        return view('pages.admin.viewresponsable')->with('user_id',$user_id);
    }

    //retourne un user par  par API
    public  function get($user_id)
    {
        $return=array();

        $equipe = User::find($user_id);


        return $equipe;
    }

    //retourne les gyms par API
    public  function getmembers($user_id)
    {
        $gyms=array();

        $user = User::find($user_id);

        if($user == null)
        {
            return null;
        }
        $gyms=$user->gymnastes()->get();

        $gc = new GymnastesController;


        return $gc->formatGyms($gyms);
    }




}
