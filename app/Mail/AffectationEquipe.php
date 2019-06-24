<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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


    public function __construct( $gym)
    {
        $gymnaste = json_decode($gym);

        print $gymnaste->nom;

        $this->nom = $gymnaste->nom;
        $this->prenom = $gymnaste->prenom;
        $this->id = $gymnaste->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[FJEP Gymnastique] Affectation de groupe')->to('gruelt@gmail.com')->view('mails.affectation');
    }
}
