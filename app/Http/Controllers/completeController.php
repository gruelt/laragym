<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class completeController extends Controller
{
    public function store(Request $request)
    {
        //TODO ajouter controles

        $this->validate($request, [
            'nom' => 'required|string|max:50|min:3',
            'prenom' => 'required|string|max:50|min:3',
            'adresse' => 'required|string|max:50|min:3',
            'telephone1' => 'required|regex:/0[1-9][0-9]{8}/|max:10',
            'telephone2' => 'required|regex:/0[1-9][0-9]{8}/|max:10'

        ]);

        print "ça serait OK";

    }
}
