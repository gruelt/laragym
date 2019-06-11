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


    public function showadmin($id)
    {
        //$gym = Gymnaste::where('id',$id)->get();

        $gym = Gymnaste::where('id',$id)->get();

        //verifie qu ele gym appartient bien


        $gym = $this->formatGyms($gym);


        return view('pages.admin.viewgymnaste')->with('gym',$gym[0]);
    }

    public function get($id)
    {
        //$gym = Gymnaste::where('id',$id)->get();

        $gym = Gymnaste::where('id',$id)->get();

        //verifie qu ele gym appartient bien


        return $this->formatGyms($gym);



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

            $problemes=array();

            //dd($gymnaste);
            $return[$key]=$gymnaste->toArray();

            $niveaux=Gymnaste::find($gymnaste->id)->equipes()->get();

            $returnniv='';

            //Gestion des Niveaux en display html et brut
            $noniv=1;
            foreach($niveaux as $niveau)
            {
                $returnniv.="<a href=\"/equipes/".$niveau['id']."\" class=\"badge badge-primary\">".$niveau->nom."</a>&nbsp;";
                $return[$key]['niveaux_tab'][$niveau['id']]=$niveau->nom;
                $noniv=0;
            }

            $return[$key]['niveaux']=$returnniv;

            if($noniv==1)
            {
                $problemes['Groupe']['nonegroup']["text"]="Attente affectation groupe";
                $problemes['Groupe']['nonegroup']["class"]="secondary";
            }


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

            //Photo basente
            if($gymnaste['photo'] == null)
            {
                $problemes['photo']['nonephoto']["text"]="Aucune photo";
                $problemes['photo']['nonephoto']["class"]="warning";

            }



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

                //Certificat dépassé
                if($agecertif >= 3)
                {
                    $problemes['certificat']['age']["text"]="Certificat médical expiré";
                    $problemes['certificat']['age']["class"]="warning";
                }

                //Certificat absent
                if($gymnaste['certificat_medical'] === null)
                {
                    $problemes['certificat']['nonecertif']["text"]="Aucun Certificat médical";
                    $problemes['certificat']['nonecertif']["class"]="warning";
                }




                //Responsable

                $responsable= $gymnaste->responsable()->first();

                $return[$key]['responsable']=$responsable;

                //Genres

                $genre= $gymnaste->genre;

                $return[$key]['genre']=$genre;

                $return[$key]['genre_libelle']=$genre->name;

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

                /** Gestion des tarifs et paiements */

                $tarif= $gymnaste->tarif();

                $return[$key]['tarif']=$tarif;

                if($reinscrire != null) {
                    if (($reinscrire->pivot->paye == 0) && $tarif != null) {
                        $problemes['paiement']['nonepaiement']["text"] = "Paiement " . $tarif . "€";
                        $problemes['paiement']['nonepaiement']["class"] = "warning";
                    }
                }



                #récupère les problèmes pour le dossier

                $return[$key]['problemes']=$problemes;

                $problemes_short="";

                foreach($problemes as $lokey => $probleme )
                {
                    $problemes_short.=$lokey." ";
                }

                if(count($problemes)==0)
                {
                    $problemes_short="OK";
                }

                $return[$key]['problemes_short']=$problemes_short;




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

        $gym->certificat_medical_check=0;

        $gym->save();

        //enregistre le path de la photo

        return back();

    }

    /**
     * Inscrit le gym à la saison
     * @param $gymnasteId
     * @param $saisonId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function inscrire($gymnasteId,$saisonId)
    {
        $gym = new Gymnaste;

        $inscription = $gym->find($gymnasteId)->saisons()->attach($saisonId);

        return back();
    }

    public function validcertif($uid)
    {
        $gym = Gymnaste::find($uid);
        $gym->certificat_medical_check =1;
        $gym->save();
    }

    /**
     * récupère les gyms d'une saison
     * @param $saison_id
     *
     * @return array|mixed
     */
    public function getbyseason($saison_id)
    {
        $return=array();

        //Si toutes les saisons confondues
        if($saison_id == 9999)
        {
            return $this->getall();
        }


        $saison=  Saison::find($saison_id);

        $gymnastes = $saison->gymnastes()->get();

        if($gymnastes->count() == 0)
        {
            return $gymnastes;
        }


        $return = $this->formatGyms($gymnastes);

        return $return;

        //return $gymnastes;
    }


    /**
     * Récupère les équipes pour une saison précise d'un gym
     */
    public function getgymequipesbyseason($gym_id,$saison_id)

    {
        return Gymnaste::find($gym_id)->equipes->pluck('id');
    }

    public function setgymequipesbyseason($gym_id,$saison_id,Request $request)
    {
        Gymnaste::find($gym_id)->equipesall()->sync($request->equipes);

        return 1;
    }




}
