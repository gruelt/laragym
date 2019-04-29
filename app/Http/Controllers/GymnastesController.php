<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gymnaste;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Array_;
use App\User;


class GymnastesController extends Controller
{


    //retourne les gyms avec leur groupe
    public function getall()
    {
        $return=array();

        $all =  Gymnaste::all();



        foreach ($all as $key => $gymnaste)
        {
            $return[$key]=$gymnaste;

            $niveaux=Gymnaste::find($gymnaste->id)->equipes()->get();

            $returnniv='';

            foreach($niveaux as $niveau)
            {
                $returnniv.="<a href=\"/equipes/".$niveau['id']."\" class=\"badge badge-primary\">".$niveau->nom."</a>&nbsp;";
            }

            $return[$key]['niveaux']=$returnniv;

        }
        return $return;

    }





    //retourne les gyms avec leur groupe
    public function getMy($id=1)
    {
        $return=array();





        $mygym =  User::find(1)->gymnastes()->get();



        foreach ($mygym as $key => $gymnaste)
        {
            $return[$key]=$gymnaste;

            $niveaux=Gymnaste::find($gymnaste->id)->equipes()->get();

            $returnniv='';

            foreach($niveaux as $niveau)
            {
                $returnniv.="<a href=\"/equipes/".$niveau['id']."\" class=\"badge badge-primary\">".$niveau->nom."</a>&nbsp;";
            }

            $return[$key]['niveaux']=$returnniv;

        }
        return $return;

    }







}
