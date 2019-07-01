<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipe;
use App\Saison;
use App\Http\Controllers\GymnastesController;

class EquipesController extends Controller
{

    public function getall()
    {
        $equipes= Equipe::all();

        return $this->formatEquipes($equipes);
    }



    /**
     * Récupère un Modèle gym , et l'étend pour l'affichage Commun
     * @param $gyms
     * @return mixed
     */
    private function formatEquipes($equipes,$extend=1)
    {
        foreach ($equipes as $key => $equipe)
        {
            $return[$key]=$equipe->toArray();

            /**  GENRE   */
            $genre= $equipe->genre()->first();

            $return[$key]['genre']=$genre;



            $return[$key]['genre_libelle']="<span class=\"badge badge-".$genre->color()."\">".$genre->description."</span>";

            /** Niveau */

            $niveau = $equipe->niveau;

            $return[$key]['niveau']=$niveau;

            $returnniv="<a href=\"/admin/niveau/".$niveau['id']."\" class=\"badge badge-primary\">".$niveau->description."</a>&nbsp;";
            $return[$key]['niveau_libelle']=$returnniv;

            /** Nombre de Gyms */

            //$return[$key]['nbgyms']=Equipe::find($key)->gymnastes();
            $return[$key]['nbgyms']=$equipe->gymnastes;

            /** Categorie  */
            $return[$key]['categorie']=$equipe->categorie->name;
            $return[$key]['filiere']=$equipe->categorie->filiere->name;

            /** Coach  */
            $coachz="";
            foreach($equipe->coach as $coach)
            {
               $coachz .="<a href=\"/admin/coach/".$coach['id']."\" class=\"badge badge-primary\">".$coach['prenom']." ".$coach['nom']. "</a>&nbsp;";
            }
            $return[$key]['coach']=$coachz;

            /** Horaires */
            $horaires=$equipe->horaires;

            $return[$key]['horaires']=$horaires;





        }

        return $return;

    }

    /**
     * Récpère les équipes d'un saison
     * @param $saison_id
     */
    public function getbyseason($saison_id,$pluck=0,$effectif=1)
    {
        $return=array();

        //Si toutes les saisons confondues
        if($saison_id == 9999)
        {
            return $this->getall();
        }


        $saison=  Saison::find($saison_id);

        $equipes = $saison->equipes()->orderBy('nom')->get();

        if($equipes->count() == 0)
        {
            return $equipes;
        }

        if($pluck == 1)
        {
            if($effectif ==0) {
                return $equipes->pluck('nom' , 'id');
            }
            else{
                $return =array();

                foreach($equipes as $key => $equipe)
                {

                    $nbgyms= Equipe::find($equipe->id)->gymnastes()->wherePivot('attente',0)->count();
                    $nbgymsattente= Equipe::find($equipe->id)->gymnastes()->wherePivot('attente',1)->count();

                    if($nbgyms < 4)
                    {
                        $class="secondary";
                    }
                    if($nbgyms >= 4 && $nbgyms <7)
                    {
                        $class="primary";
                    }
                    if($nbgyms >= 7)
                    {
                        $class="warning";
                    }
                    if($nbgyms >= 10 )
                    {
                        $class="danger";
                    }

//                    $return[$equipe->id]['html']=$equipe->nom." : <b>"  .$nbgyms."</b> Gyms/".$nbgymsattente." en attente. ";


                    $return[$equipe->id]['html']="<button type=\"button\" class=\"btn btn-".$class."\">
  $equipe->nom <span class=\"badge badge-light\">$nbgyms</span>
</button>";



                }
                return $return;
            }

        }


        $return = $this->formatEquipes($equipes);

        return $return;

        //return $gymnastes;
    }

    public function getbyseasonpluck($saison_id)
    {
       $return = $this->getbyseason($saison_id)->orderBy('nom','asc')->pluck('id','nom');
        return json_encode($return);
    }

    public function showequipe($equipe_id)
    {
        $return =array();

        $equipe = Equipe::find($equipe_id);

        return view('pages.admin.viewequipe')->with('equipe_id',$equipe_id);
    }

    //retourne une equipe par API
    public  function get($equipe_id)
    {
        $return=array();

        $equipe = Equipe::where('id',$equipe_id)->get();


        return $this->formatEquipes($equipe)[0];
    }

    //retourne une equipe par API
    public  function getmembers($equipe_id)
    {
        $return=array();

        $equipe = Equipe::find($equipe_id)->gymnastes()->get();

        $gc = new GymnastesController;


        return $gc->formatGyms($equipe);
    }


    /**
     * Retourne les coachs affectés à l'équipe
     * @return array
     */
    public function getcoachspluck($id_equipe)
    {



        $coachs = Equipe::find($id_equipe)->coach()->pluck('users.id');








        return $coachs;

        //return $gymnastes;
    }

    /**
     * Affecte les coachs à l'equipe
     * @param $equipe_id
     * @param Request $request
     * @return int
     */
    public function setcoachtoteam($equipe_id,Request $request)
    {

        Equipe::find($equipe_id)->coach()->sync($request->coachs);




        return 1;
    }



}
