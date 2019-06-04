<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipe;

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




        }

        return $return;

    }
}
