<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privileges extends Model
{
    public function users()
    {

        return $this->belongsToMany(User::class)->WithTimeStamps();

    }
}
