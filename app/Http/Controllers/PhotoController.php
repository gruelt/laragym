<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function takephoto($gym_id)
    {
        return view('pages.takephoto')->with('gym_id',$gym_id);
    }
}
