<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gymnaste;
use phpDocumentor\Reflection\Types\Array_;
use App\User;
use Illuminate\Contracts\Auth\Guard;

class GymnastesController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->currentUser = $auth->user();
    }

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
    public function getMy()
    {
        $return=array();



        return $this->currentUser;

        $mygym =  User::find()->gymnastes();



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
