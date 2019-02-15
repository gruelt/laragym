<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gymnaste;

class GymnastesController extends Controller
{

    public function getall()
    {
        return Gymnaste::all();

    }

}
