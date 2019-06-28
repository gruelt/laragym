<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gymnaste;

class PhotoController extends Controller
{
    public function takephoto($gym_id)
    {
        return view('pages.takephoto')->with('gym_id',$gym_id);
    }

    public function cropphoto($gym_id)
    {
        $gym = Gymnaste::find($gym_id);
        return view('pages.cropphoto',compact('gym'));
    }

    public function formtest(){
        return view('pages.testphoto');
    }
}
