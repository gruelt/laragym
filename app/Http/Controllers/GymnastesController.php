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



        $return = $this->formatGyms($all);

        return $return;

    }





    //retourne les gyms avec leur groupe
    public function getMy()
    {






        $mygym =  User::find(Auth::user()->id)->gymnastes()->get();


        $return = $this->formatGyms($mygym);


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



        return redirect('/responsable/gymnastes/'.$gym->id)->withMessage("Gymnaste ajouté !");






    }




    public function show($id)
    {
          //$gym = Gymnaste::where('id',$id)->get();

        $gym = Gymnaste::where('id',$id)->get();

        //verifie qu ele gym appartient bien

        //Si ce n'est pas un des gymns du responsable , et qu'il n'à aucun droit.
        if (Auth::user()->id != Gymnaste::find($id)->responsable()->first()->id && User::find(Auth::user()->id)->count()==0)
        {
            return view('pages.responsables.adherents')->withMessage('Ce gymnaste n\'est pas sous votre responsabilité');
        }

        $gym = $this->formatGyms($gym);


        return view('pages.responsables.viewgymnaste')->with('gym',$gym[0]);
    }


    /**
     * Récupère un Modèle gym , et l'étend pour l'affichage Commun
     * @param $gyms
     * @return mixed
     */
    private function formatGyms($gyms)
    {
        foreach ($gyms as $key => $gymnaste)
        {
            //dd($gymnaste);
            $return[$key]=$gymnaste->toArray();

            $niveaux=Gymnaste::find($gymnaste->id)->equipes()->get();

            $returnniv='';

            //Gestion des Niveaux en display html et brut
            foreach($niveaux as $niveau)
            {
                $returnniv.="<a href=\"/equipes/".$niveau['id']."\" class=\"badge badge-primary\">".$niveau->nom."</a>&nbsp;";
                $return[$key]['niveaux_tab'][$niveau['id']]=$niveau->nom;
            }

            $return[$key]['niveaux']=$returnniv;

            //Date de Naissanc En Français
            $date = Carbon::parse($gymnaste['date_naissance'])->format('d-m-Y');

            $return[$key]['date_naissance_fr']=$date;

        }

        return $return;

    }




}
