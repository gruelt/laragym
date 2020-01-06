<?php

namespace App\Http\Controllers;

use App\Exports\GymnastesExport;
use App\Exports\GymnastessaisonExport;
use App\Saison;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Gymnaste;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Array_;
use App\User;
use App\Equipe;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Support\Facades\Redis;

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


        $return = $this->formatGyms($mygym,1,true);


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
        if($request->admin==1 && isset($request->user_id))
        {
            $gym->user_id = $request->user_id;
        }
        else {
            $gym->user_id = Auth::user()->id;
        }
        $gym->commentaire = $request->commentaire;




        $gym->save();

        //Insciption pour la saison ouverte aux inscriptions actuelle
        $saison = new Saison;

        $gym->saisons()->attach($saison->inscriptionOuverte()->id);



        if($request->admin==1 && isset($request->user_id))
        {
            return redirect('/admin/responsables/' . $gym->user_id)->withMessage("Gymnaste ajouté !");
        }
        else {
            return redirect('/responsable/gymnastes/' . $gym->id)->withMessage("Gymnaste ajouté !");
        }






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
    public function formatGyms($gyms,$extend=1,$refresh=false)
    {
        $return=array();
	//$refresh=false;

        if(count($gyms)==1)
        {
            $refresh=true;
        }

        foreach ($gyms as $key => $gymnaste)
        {
            $cache=Redis::get('gymnaste.'.$gymnaste->id);

            if($cache && $refresh!=true) {

                $return[$key] = json_decode($cache,true);
            }
            else
            {

                $problemes = array();

                //dd($gymnaste);
                $return[$key] = $gymnaste->toArray();

                //competitif ou non

                $return[$key]['competitifsaison'] = $gymnaste->competitif();

                $niveaux = Gymnaste::find($gymnaste->id)->equipes()->get();

                $returnniv = '';

                //Gestion des Niveaux en display html et brut
                $noniv = 1;
                $horaires = array();
                $horairescompact = "";
                foreach ($niveaux as $niveau) {
                    $attente = "";
                    $class = "badge badge-info";
                    if ($niveau->pivot->attente == 1) {
                        $attente = "<b>Liste d'Attente</b>";
                        $class = "badge badge-danger";
                    }
                    $returnniv .= "<a href=\"/equipes/" . $niveau['id'] . "\" class=\"" . $class . "\">" . $niveau->nom . " " . $attente . "</a>&nbsp;";
                    $return[$key]['niveaux_tab'][$niveau['id']]['nom'] = $niveau->nom;
                    $return[$key]['niveaux_tab'][$niveau['id']]['attente'] = $niveau->pivot->attente;
                    $noniv = 0;

                    $ho = Equipe::find($niveau->id);

                    $horaires[$niveau['nom']] = $ho->horaires;

                    foreach ($ho->horaires as $horaire) {
                        $horairescompact .= $horaire->jour->nom_jour . "<br>";//.$horaire->heure_debut."h".$horaire->minute_debut;
                    }

                }

                $return[$key]['horaires'] = $horaires;

                $return[$key]['horairescompact'] = $horairescompact;

                $return[$key]['niveaux'] = $returnniv;


                //Gestion des saisons


                $saisons = $gymnaste->saisons()->get();

                $return[$key]['saisons'] = $saisons;


                if ($gymnaste->birthday()) {
                    $problemes['anniversaire']['anniv']["text"] = "Bon anniversaire";
                    $problemes['anniversaire']['anniv']["class"] = "info";

                }


                //Date de Naissanc En Français
                $date = Carbon::parse($gymnaste['date_naissance'])->format('d-m-Y');

                $age = Carbon::parse($gymnaste['date_naissance'])->age;

                $return[$key]['date_naissance_fr'] = $date;

                $return[$key]['age'] = $age;

                //Gestion Photo
                if ($gymnaste['photo'] != null) {
                    $photo_url = Storage::disk('public')->url($gymnaste['photo']);
                } else {
                    $photo_url = "/images/anonym.jpg";
                }

                //dd($gymnaste);
                //Photo absente pour compétitif
                if ($gymnaste['photo'] == null && Gymnaste::find($gymnaste['id'])->competitif() > 0) {
                    $problemes['photo']['nonephoto']["text"] = "Aucune photo";
                    $problemes['photo']['nonephoto']["class"] = "warning";

                }


                $return[$key]['photo_url'] = $photo_url;


                //Infos Etendues
                if ($extend == 1) {
                    //Gestion Certificat
                    $certif_url = Storage::disk('public')->url($gymnaste['certificat_medical']);


                    if ($gymnaste['certificat_medical_date'] == null) {
                        $datecertif = "Entrer date certificat Affiligue";

                        $datefincertif = Carbon::parse($gymnaste['certificat_medical_date'])->addYears(3)->format('d-m-Y');

                        $agecertif = Carbon::parse($gymnaste['certificat_medical_date'])->age;

                        $return[$key]['certificat_medical_date_fr'] = $datecertif;

                        $return[$key]['certificat_medical_url'] = $certif_url;

                        $return[$key]['certificat_medical_age'] = $agecertif;

                        $return[$key]['certificat_medical_fin_fr'] = $datefincertif;
                    } else {


                        $datecertif = Carbon::parse($gymnaste['certificat_medical_date'])->format('d-m-Y');

                        $datefincertif = Carbon::parse($gymnaste['certificat_medical_date'])->addYears(3)->format('d-m-Y');

                        $agecertif = Carbon::parse($gymnaste['certificat_medical_date'])->age;

                        $return[$key]['certificat_medical_date_fr'] = $datecertif;

                        $return[$key]['certificat_medical_url'] = $certif_url;

                        $return[$key]['certificat_medical_age'] = $agecertif;

                        $return[$key]['certificat_medical_fin_fr'] = $datefincertif;
                    }


                    //Certificat dépassé
                    if ($agecertif >= 3) {
                        $problemes['certificat']['age']["text"] = "Certificat médical expiré";
                        $problemes['certificat']['age']["class"] = "warning";
                    }

                    //Certificat absent
                    if ($gymnaste['certificat_medical'] === null && $gymnaste['certificat_medical_date'] == null) {
                        $problemes['certificat']['nonecertif']["text"] = "Aucun Certificat médical";
                        $problemes['certificat']['nonecertif']["class"] = "warning";
                    }

                    //Certificat non verifié
                    if ($gymnaste['certificat_medical_check'] == 0 && $gymnaste['certificat_medical_date'] != null) {
                        $problemes['verif_certificat']['verifcertif']["text"] = "Certificat medical à verifier";
                        $problemes['verif_certificat']['verifcertif']["class"] = "warning";
                    }


                    //Responsable

                    $responsable = $gymnaste->responsable()->first();

                    $return[$key]['responsable'] = $responsable;

                    //Genres

                    $genre = $gymnaste->genre;

                    $return[$key]['genre'] = $genre;

                    $return[$key]['genre_libelle'] = $genre->name;

                    //A reinscrire

                    $saisonInscription = new Saison;

                    $saisoni = $saisonInscription->inscriptionOuverte();

                    $reinscrire = null;

                    if ($saisoni != null && $gymnaste->saisons()->find($saisoni->id) != null) {
                        $reinscrire = $gymnaste->saisons()->find($saisoni->id);


                        $return[$key]['reinscrit']['saison'] = $saisoni;

                        $return[$key]['dossier'] = $reinscrire->pivot->dossier;
                        //Si dossier non complet
                        if ($reinscrire->pivot->dossier == 0 || $reinscrire->pivot->dossier == null) {
                            $problemes['dossier']['absent']["text"] = "Dossier non complet, à remplir au gymnase ";
                            $problemes['dossier']['absent']["class"] = "warning";
                        } //Si complet on check l'affiligue
                        else {

                            if ($reinscrire->pivot->affiligue == 0 && $reinscrire->pivot->dossier != 2) {
                                $problemes['affiligue']['nonsaisi']["text"] = "Validation affiligue à faire par gestionnaire ";
                                $problemes['affiligue']['nonsaisi']["class"] = "warning";
                            }
                        }

                    } else {
                        $reinscrire = null;

                        if ($saisoni != null) {
                            $return[$key]['reinscrit']['saison'] = $saisoni;
                            $problemes['reinscription']['nonfait']["text"] = "Pas de reinscription ";
                            $problemes['reinscription']['nonfait']["class"] = "warning";
                        } else {
                            $return[$key]['reinscrit']['saison'] = 0;

                        }

                    }

                    if ($reinscrire == null) {
                        $return[$key]['reinscrit']['statut'] = 0;


                    } else {
                        $return[$key]['reinscrit']['statut'] = 1;
                        if ($noniv == 1) {
                            $problemes['Groupe']['nonegroup']["text"] = "Attente affectation groupe. Pour les non compétitifs et les nouveaux inscrits , veuillez passer au gymnase !";
                            $problemes['Groupe']['nonegroup']["class"] = "secondary";
                        }

                    }

                    /** Gestion des tarifs et paiements */

                    $tarif = $gymnaste->tarif();

                    $return[$key]['tarif'] = $tarif;

                    if ($reinscrire != null) {
                        if (($reinscrire->pivot->paye == 0) && $tarif != null) {
                            $problemes['paiement']['nonepaiement']["text"] = "Tarif  " . $tarif . "€ à Valider par Gestionnaire";
                            $problemes['paiement']['nonepaiement']["class"] = "warning";
                        }

                    }

                    // montant validé pour le gymnaste
                    $paye = $gymnaste->paye();

                    $return[$key]['paye'] = $paye;

                    // montant total pour la famille du gymnaste
                    $totalapayer = $gymnaste->totalapayer();

                    $return[$key]['totalapayer'] = $totalapayer;


                    #récupère les problèmes pour le dossier

                    $return[$key]['problemes'] = $problemes;

                    $problemes_short = "";

                    foreach ($problemes as $lokey => $probleme) {
                        $problemes_short .= $lokey . " ";
                    }

                    if (count($problemes) == 0) {
                        $problemes_short = "OK";
                    }

                    $return[$key]['problemes_short'] = $problemes_short;


                }

                //met en place la key dans redis
                Redis::set('gymnaste.' . $gymnaste->id, json_encode($return[$key]),'EX',3600*24*7);


            }

        }



        return $return;

    }



    /**
     * Upload File
     **/
    public function uploadPhoto($id,Request $request) {

        $request->validate([

            'laphoto' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);


        $photo= $request->laphoto;

//        $exif = exif_read_data($request->file('laphoto'));
//        if(!empty($exif['Orientation'])) {
//            switch($exif['Orientation']) {
//                case 8:
//                    $image = imagerotate($laphoto,90,0);
//                    break;
//                case 3:
//                    $image = imagerotate($laphoto,180,0);
//                    break;
//                case 6:
//                    $image = imagerotate($laphoto,-90,0);
//                    break;
//            }
//        }

        $photo = \Image::make($request->file('laphoto')->getRealpath());
        $photo->orientate();

        //Fin rotation


        //récupère l'extension
        $ext = $request->laphoto->getClientOriginalExtension();

        //Infos dy gym :
        $gym = Gymnaste::find($id);
        //dd($gym.$id);
        $filename = $id."_".$gym->nom."_".$gym->prenom.".".$ext;


        //Supprime les anciennes
        Storage::delete('public/'.$gym->photo);

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
    public function uploadPhoto64($id,$redirect="",Request $request) {

        $ext = "png";

        $img = $request->laphoto;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        //Infos dy gym :
        $gym = Gymnaste::find($id);
        //dd($gym.$id);
        $filename = $id."_".$gym->nom."_".$gym->prenom.".".$ext;

        //Supprime les anciennes
        Storage::delete('public/'.$gym->photo);

        //Stocke en local
        //$path = $data->storeAs('', $filename, 'public');
        Storage::put("/public/".$filename,$data);

        $gym->photo=$filename;

        $gym->save();

        //récupère l'extension
    //return $redirect;
        if($redirect != "")
        {
            return redirect('/admin/gymnastes/'.$id);
        }
        else {
            return 1;
        }
    }



    /**
     * Upload File
     **/
    public function uploadCertif($id,Request $request) {



        $request->validate([

            'lecertif' => 'required|mimes:jpeg,png,jpg,pdf|max:10120',
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

        //Supprime les anciennes
        Storage::delete('public/'.$gym->certificat_medical);

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
            $return = $this->getall();
            return $this->formatGyms($return);
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
     * récupère les gyms d'une saison
     * @param $saison_id
     *
     * @return array|mixed
     */
    public function getbyseasonquick($saison_id)
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


        $return = $gymnastes;

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

        //Mail::send(new \App\Mail\AffectationEquipe(Gymnaste::find($gym_id)));


        return 1;
    }

    public function updateequipeattente($gym_id,$equipe_id,$attente)
    {


        $gym =   Gymnaste::find($gym_id)->equipes()->updateExistingPivot($equipe_id,['attente'=>$attente]);





        return $gym;

    }

    public function updatedossier($gym_id,$statut)
    {
        $sai= new Saison;
        $saison = $sai->inscriptionOuverte()->id;
        $return = Gymnaste::find($gym_id)->saisons()->updateExistingPivot($saison,['dossier'=>$statut]);
        return $return;

    }

    public function updateaffiligue($gym_id,$statut)
    {
        $sai= new Saison;
        $saison = $sai->inscriptionOuverte()->id;
        $return = Gymnaste::find($gym_id)->saisons()->updateExistingPivot($saison,['affiligue'=>$statut]);
        return $return;

    }

    /**
     * @param $saison_id
     * @return Excel|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export($saison_id)
    {
        return Excel::download(new GymnastessaisonExport, 'gymnastes.xlsx');
    }



    public function PDFFacture($gymnaste_id,$admin=0)
    {
        $gymnaste=Gymnaste::find($gymnaste_id);

        if ($admin ==0 && Auth::user()->id != Gymnaste::find($gymnaste_id)->responsable()->first()->id ) // && User::find(Auth::user()->id)->count()==0
        {
            return redirect('responsable/gymnastes/');
        }


        $paye =  $gymnaste->paye();
    //vérifie que le montant est payé
        if($paye==0)
        {
            return redirect("/");
        }

            //dd($gymnaste);
        $data=[
            'nom' => $gymnaste->nom,
            'prenom' => $gymnaste->prenom,
            'adresse' => $gymnaste->responsable->adresse,
            'ville' => $gymnaste->responsable->ville,
            'cp' => $gymnaste->responsable->cp,
            'nom_responsable' =>  $gymnaste->responsable->nom,
            'prenom_responsable' => $gymnaste->responsable->prenom,
            'montant' => $paye
    ];


        $pdf = PDF::loadView('PDF.attestation2019', $data);
        //dd($data);
        return $pdf->stream($data['nom'] ."_".$data['prenom']. '-2019.pdf');
    }

    public function redis()
    {
        if(Redis::get('gymnaste.2'))
        {
            print "ok";
        }
        else{
            print "not ok";
        }
        return Redis::get('gymnaste.2');
    }





}
