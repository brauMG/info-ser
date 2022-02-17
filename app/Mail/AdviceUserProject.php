<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdviceUserProject extends Mailable
{
    public $pmo;
    public $usuario;
    public $proyecto;
    public $rol;
    public $subject = "Nuevo Usuario Agregado A Proyecto En Ser";

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pmo, $user, $project, $rol)
    {
        $this->pmo = $pmo;
        $this->usuario = $user;
        $this->proyecto = $project;
        $this->rol = $rol;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.advice-user-project');
    }
}
