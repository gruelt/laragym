<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gymnaste;
use phpDocumentor\Reflection\Types\Array_;

class GymnastesController extends Controller
{

    //retourne les gyms avec leur groupe
    public function getall()
    {
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

}
