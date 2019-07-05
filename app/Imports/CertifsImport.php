<?php

namespace App\Imports;

use App\Gymnaste;
use Maatwebsite\Excel\Concerns\ToModel;

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

       print $nom ." - ".$prenom . " = ".$datefin."\n";
    }
}
