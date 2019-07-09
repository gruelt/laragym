<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class completeController extends Controller
{
    public function store(Request $request)
    {


        $this->validate($request, [
            'nom' => 'required|string|max:50|min:3',
            'prenom' => 'required|string|max:50|min:3',
            'adresse' => 'required|string|max:50|min:3',
            'telephone1' => 'required|regex:/0[1-9][0-9]{8}/|max:10',
            'telephone2' => 'required|regex:/0[1-9][0-9]{8}/|max:10'

        ]);
        if($request->new ==1) {
            $user = new User;

            $user->name = $request->nom;
            $user->email =  $request->email;
            $user->password =  "bachibouzouk42133443zarma";
        }
        else
        {
            $user = User::find(Auth::user()->id);
        }

            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->ville= $request->ville;
            $user->cp = $request->cp;
            $user->telephone1 = $request->telephone1;
            $user->telephone2 = $request->telephone2;

            $user->adresse = $request->adresse;
            $user->profession =$request->profession;
            $user->complete =1;



            $user->save();


        if($request->new ==1) {
            return redirect('/admin/responsables')->withMessage("Nouveau Responsable créé");
        }
        else{


            return redirect('/home')->withMessage("Vos Informations sont complétées ! Vous pouvez Inscrire vos gymnastes");

        }




    }
}
