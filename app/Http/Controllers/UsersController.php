<?php

namespace App\Http\Controllers;

use App\Privileges;
use App\User;
use Illuminate\Http\Request;

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

}
