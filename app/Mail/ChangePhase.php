<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangePhase extends Mailable
{
    public $usuario;
    public $proyecto;
    public $fase;
    public $subject = "Un Proyecto Cambio De Fase En SER";

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $project, $phase)
    {
        $this->usuario = $user;
        $this->proyecto = $project;
        $this->fase = $phase;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.change-phase');
    }
}
