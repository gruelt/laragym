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

    public function formatEquipes($equipes,$extend=1)
    {
        return $equipes;
    }


}
