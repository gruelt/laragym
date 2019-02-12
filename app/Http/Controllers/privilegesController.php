<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Privileges;
use App\User;
use App\Gestion\General;

class privilegesController extends Controller
{

    /**
     * GetDroits : récupère un array des droits du porteur, les droits sont cumulatifs.
     *        -> Par défaut tout le monde à le droit 4 => Visiteur ( il à passé l'authentification Ldap)
     *        -> Si on est un porteur qui existe dans la base (actif ou non ) on à le droit 3 => Porteur
     *        -> On récupère les droits dans la base de données des droits( pour superadmin et gestionnaire)
     *        -> Si on est valideur d'un/plusieurs groupes on hérite automatiquement du droit valideur
     * @param  int $idporteur identifiant en base du porteur, si Null , on renvoit visiteur
     * @return array Array des droits du porteur , sous forme de int id en base
     */
    public function getPrivileges($iduser=null)
    {

        /**
         *  Si $iduser est null = le user a passé CAS , mais n'est pas connu en tant que utilisateur
         *  On lui met systematiquement le droit visiteur
         */

        if(is_null($iduser))
        {
            $droits[]=4;

            return $droits;
        }


        /**
         * Droits en base pour superadmin et gestionnaire
         */

        $droitsDb = User::find($iduser)->privileges()->get();

        foreach($droitsDb as $key => $droit)
        {
            $droits[]=$droit['id'];
        }



        /**
         * Droit visiteur systématique
         */
        $droits[]=4;



        /**
         * Renvoie le array des droits
         */

        return $droits;
    }

    /**
     * SetDroits
     * @param int $idporteur identifiant en base du porteur
     * @param array $droits    [description]
     */
    public function setPrivileges($iduser,$privileges)
    {
        // TO DO
    }



    /**
     * getDroitDescription récupère les details sur un droit en particulier
     * @param  int $id identifiant en base du droit
     * @return string array des infos sur le droit [ nom , description ]
     */
    public function getPrivilegeInfo($id)
    {

        $record = Privileges::find($id)->get();

        return $record;

    }

    /**
     * getDroitid récupère l'id' droit en particulier
     * @param  string $droit string en base du droit
     * @return int id du droit
     */
    public function getPrivilegeId($droit)
    {

        $record = Privileges::where('name',$droit)->first();

        return $record->id;

    }

    /**
     * getPossibleDroits un tableau des droits possibles
     *
     * @return int id du droit
     */
    public function getPossiblePrivileges()
    {

        $record = Privileges::all()->pluck('name','id');

        return $record;

    }







}
