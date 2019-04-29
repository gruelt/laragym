<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Retourne le(s) droits de l'utilisateur enregistré en base (n'inclue pas les droits auto).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function privileges()
    {

        return $this->belongsToMany(Privileges::class)->WithTimeStamps();

    }

    public function complete()
    {


    }




}
