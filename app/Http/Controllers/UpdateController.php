<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;
use PhpParser\Node\Scalar\String_;

class UpdateController extends Controller
{
    /**
     * @param String_ $model
     * @param Integer $id
     * @param String $field
     * @param Request $request
     * @return int
     */
    public function univupdate($model, $id, $field,Request $request)

    {

        $model = 'App\\' . $model;

        $modeldata=$model::find($id);

        $modeldata->$field = $request->value;

        $modeldata->save();

        return json_encode($modeldata);




    }
}
