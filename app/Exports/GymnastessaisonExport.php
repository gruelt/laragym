<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Saison;
use App\Http\Controllers\GymnastesController;


class GymnastessaisonExport implements FromView
{

public function view(): View
{
    $s=new Saison;
    $saison_id_actuelle = $s->actuelle()->id;

    //dd($saison_id_actuelle);
    $gc = new GymnastesController();

    $gymnastes =  $gc->getbyseason($saison_id_actuelle);

    $url="http://my.fjepgym.fr/admin/gymnastes";

    //dd($gymnastes);

    foreach($gymnastes as $key => $gym)
    {
        $niveau="";
        if(isset($gym['niveaux_tab']))
        {
            foreach($gym['niveaux_tab'] as $groupe)
            {
                //dd($groupe);
                $niveau.=$groupe['nom'] ."|";
            }
        }

        $data[$key]=[
            //'lien myfjep'=>'<a href=\"'.$url."/".$gym['id']."\">Voir fiche</a>",
            'id'=>$gym['id'],

            'nom'=>$gym['nom'],

            'prenom'=>$gym['prenom'],

            'date naissance'=>$gym['date_naissance_fr'],

            'tarif'=>$gym['tarif'],
            'paye a inscription'=>$gym['paye'],
            'niveau'=>$niveau
            ];
    }


return view('exports.compta', [

    'data' => $data


//'data' => [
//        [
//        'name' => 'Povilas',
//        'surname' => 'Korop',
//        'email' => 'povilas@laraveldaily.com',
//        'twitter' => '@povilaskorop'
//        ],
//
//        [
//        'name' => 'Taylor',
//        'surname' => 'Otwell',
//        'email' => 'taylor@laravel.com',
//        'twitter' => '@taylorotwell'
//        ]
//        ]
]);

}
}