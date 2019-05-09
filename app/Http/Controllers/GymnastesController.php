<?php

namespace App\Http\Controllers;

use App\Saison;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Gymnaste;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Array_;
use App\User;
use Illuminate\Support\Facades\Storage;

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

        //Insciption pour la saison ouverte aux inscriptions actuelle
        $saison = new Saison;

        $gym->saisons()->attach($saison->inscriptionOuverte()->id);




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
    private function formatGyms($gyms,$extend=1)
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


            //Gestion des saisons



            $saisons= $gymnaste->saisons()->get();

            $return[$key]['saisons']=$saisons;







            //Date de Naissanc En Français
            $date = Carbon::parse($gymnaste['date_naissance'])->format('d-m-Y');

            $age = Carbon::parse($gymnaste['date_naissance'])->age;

            $return[$key]['date_naissance_fr']=$date;

            $return[$key]['age']=$age;

            //Gestion Photo
            $photo_url=Storage::disk('public')->url($gymnaste['photo']);



            $return[$key]['photo_url']=$photo_url;





            //Infos Etendues
            if($extend==1)
            {
                //Gestion Certificat
                $certif_url=Storage::disk('public')->url($gymnaste['certificat_medical']);



                $datecertif = Carbon::parse($gymnaste['certificat_medical_date'])->format('d-m-Y');

                $datefincertif = Carbon::parse($gymnaste['certificat_medical_date'])->addYears(3)->format('d-m-Y');

                $agecertif = Carbon::parse($gymnaste['certificat_medical_date'])->age;

                $return[$key]['certificat_medical_date_fr']=$datecertif;

                $return[$key]['certificat_medical_url']=$certif_url;

                $return[$key]['certificat_medical_age']=$agecertif;

                $return[$key]['certificat_medical_fin_fr']=$datefincertif;


                //Responsable

                $responsable= $gymnaste->responsable()->first();

                $return[$key]['responsable']=$responsable;

                //Genres

                $genre= $gymnaste->genre->first();

                $return[$key]['genre']=$genre;

                //A reinscrire

                $saisonInscription = new Saison;

                $saisoni= $saisonInscription->inscriptionOuverte();

                if($saisoni != null) {
                    $reinscrire = $gymnaste->saisons()->find($saisoni->id);
                    $return[$key]['reinscrit']['saison']=$saisoni;
                }
                else{
                    $reinscrire = null;
                    $return[$key]['reinscrit']['saison']="0";
                }

                if($reinscrire == null)
                {
                    $return[$key]['reinscrit']['statut']=0;


                }
                else{
                    $return[$key]['reinscrit']['statut']=1;

                }






            }



        }

        return $return;

    }



    /**
     * Upload File
     **/
    public function uploadPhoto($id,Request $request) {
        $request->validate([

            'laphoto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        //récupère la photo
        $photo= $request->laphoto;
        //récupère l'extension
        $ext = $photo->getClientOriginalExtension();

        //Infos dy gym :
        $gym = Gymnaste::find($id);
        //dd($gym.$id);
        $filename = $id."_".$gym->nom."_".$gym->prenom.".".$ext;

        //Stocke en local
        $path = $request->laphoto->storeAs('', $filename, 'public');

        $gym->photo=$filename;

        $gym->save();

        //enregistre le path de la photo

        return back();

    }

    /**
     * Upload File
     **/
    public function uploadCertif($id,Request $request) {



        $request->validate([

            'lecertif' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
            'certificat_medical_date' => 'required|date'
        ]);



        //récupère la photo
        $certif= $request->lecertif;
        //récupère l'extension
        $ext = $certif->getClientOriginalExtension();

        //Infos dy gym :
        $gym = Gymnaste::find($id);
        //dd($gym.$id);
        $filename = $id."_".$gym->nom."_".$gym->prenom.".".$ext;

        //Stocke en local
        $path = $request->lecertif->storeAs('certificats', $filename, 'public');





        $gym->certificat_medical='certificats/'.$filename;

        $gym->certificat_medical_date=$request->certificat_medical_date;

        $gym->save();

        //enregistre le path de la photo

        return back();

    }


}
