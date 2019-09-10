<?php

namespace App\Exports;

use App\Gymnaste;
use App\Http\Controllers\GymnastesController;
use App\Saison;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;

class GymnastesExport implements FromQuery, WithMapping
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public abstract function query()
    {
        //return Gymnaste::all();
        $s=new Saison;
        $saison_id_actuelle = $s->actuelle()->id;

        //dd($saison_id_actuelle);
        $gc = new GymnastesController();

        $gymnastes =  $gc->getbyseason($saison_id_actuelle);

        return [
            $gymnastes->id
        ];
;    }
}
