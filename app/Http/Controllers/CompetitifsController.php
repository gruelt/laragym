<?php

namespace App\Http\Controllers;

use App\Competitif;
use App\Saison;
use Illuminate\Http\Request;

class CompetitifsController extends Controller
{

    public function getall()
    {
        $equipes= Competitif::with(['niveau','categorie','genre','saison'])->get();

        return $this->formatEquipes($equipes);
    }



    public function getbyseason($saison_id,$pluck=0,$effectif=1)
    {
        $return=array();

        //Si toutes les saisons confondues
        if($saison_id == 9999)
        {
            return $this->getall();
        }


        $saison=  Saison::find($saison_id);

        $equipes = $saison->competitifs()->with(['niveau','categorie','genre','saison'])->orderBy('nom')->get();

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
            if($equipe->gymnastes ==null)
            {
                $return[$key]['nbgyms_count']=0;
                $return[$key]['nbgyms']=0;
            }
            else{
                $return[$key]['nbgyms_count']=$equipe->gymnastes->count();
            }


            /** Categorie  */
            $return[$key]['categorie']=$equipe->categorie->name;
            $return[$key]['filiere']=$equipe->categorie->filiere->name;








        }

        return $return;

    }


    public function showequipe($equipe_id)
    {
        $return =array();

        $equipe = Competitif::find($equipe_id);

        return view('pages.admin.viewcompetitif')->with('equipe_id',$equipe_id);
    }


    //retourne une equipe par API
    public  function get($equipe_id)
    {
        $return=array();

        $equipe = Competitif::where('id',$equipe_id)->get();


        return $this->formatEquipes($equipe)[0];
    }




}
