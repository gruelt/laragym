<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

            $date = Carbon::parse($gymnaste['date_naissance'])->format('d-m-Y');

            $return[$key]['date_naissance_fr']=$date;

        }
        return $return;

    }


    public function store(Request $request)
    {


        $this->validate($request, [
            'nom' => 'required|string|max:50|min:3',
            'prenom' => 'required|string|max:50|min:3',
            'date_naissance' => 'date|required'


        ]);

        $gym = new  Gymnaste;

        $date = Carbon::parse($request->date_naissance);

        $date = $date->format('Y-m-d');


        $gym->nom = $request->nom;
        $gym->prenom = $request->prenom;
        $gym->date_naissance= $date;
        $gym->genre_id = $request->genre;
        $gym->user_id = Auth::user()->id;
        $gym->commentaire = $request->commentaire;




        $gym->save();



        return redirect('/responsable/gymnastes')->withMessage("Gymnaste ajouté !");






    }







}
