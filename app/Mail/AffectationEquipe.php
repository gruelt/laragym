<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Gymnaste;

class AffectationEquipe extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $nom;
    public $prenom;
    public $id;
    public $mailresponsable;


    public function __construct( $gym)
    {
        $gymnaste = json_decode($gym);

        print $gym;

        $this->nom = $gymnaste->nom;
        $this->prenom = $gymnaste->prenom;
        $this->id = $gymnaste->id;
        $this->email = Gymnaste::find($gymnaste->id)->responsable->email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[FJEP Gymnastique] Affectation de groupe')->to($this->email)->view('mails.affectation');
    }
}
