<?php

namespace App\Imports;

use App\Gymnaste;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class CertifsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       $nom = $row[0];
       $prenom =$row[1];
       $datefin = $row[2];

       #print $nom ." - ".$prenom . " =*".$datefin."*\n";

        //$date = Carbon::parse($datefin);



       $gym = Gymnaste::where([['nom','like',$nom],['prenom','like','%'.$prenom.'%']]);

      if($gym->count() ==1)
      {
          $zegym=$gym->first();

          if($zegym->certificat_medical_date == null && $zegym->certificat_medical == null && $datefin!= "") {

              $date = Carbon::createFromFormat('d/m/Y', $datefin)->subYears(3);

              $date = $date->format('Y-m-d');

              print $zegym->nom . " " . $zegym->prenom . "-" . $zegym->date_certificat_medical . "->" . $date . "\n";

              $zegym->certificat_medical_date = $date;


                  $zegym->save();

          }



      }

      if($gym->count()>1)
      {
          print "Doublons pour $nom********************"."\n";
          foreach($gym->get() as $doublon)
          {
              print $doublon->nom . " ".$doublon->prenom.$doublon->id."\n";
          }
      }



    }
}
