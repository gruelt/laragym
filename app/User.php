<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail
{
    use HasApiTokens,Notifiable;

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

    public function paiements()
    {
        return $this->hasMany(Paiement::class,'responsable_id');
    }



    /**
     * Retourne le(s) droits de l'utilisateur enregistré en base (n'inclue pas les droits auto).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function privileges()
    {

        return $this->belongsToMany(Privileges::class)->WithTimeStamps();

    }

    /**
     * Recupere les gymnastes du responsable
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gymnastes()
    {
        return $this->hasMany(Gymnaste::class)->with('saisons');
    }



    /**
     * Récupère les équipes du coach
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function equipes()
    {
        return $this->belongsToMany('App\Equipe','coach_equipe');
    }

    public function saisons()
    {




    }




}
