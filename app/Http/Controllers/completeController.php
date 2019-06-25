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

        $user = User::find(Auth::user()->id);

//dd($request);
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



        return redirect('/home')->withMessage("Vos Informations sont complétées ! Vous pouvez Inscrire vos gymnastes");






    }
}
