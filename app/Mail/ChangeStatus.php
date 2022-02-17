<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeStatus extends Mailable
{
    public $usuario;
    public $bloquea;
    public $proyecto;
    public $estado;
    public $subject = "Un Proyecto Cambio De Estado En SER";

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $lock, $project, $status)
    {
        $this->usuario = $user;
        $this->bloquea = $lock;
        $this->proyecto = $project;
        $this->estado = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.change-status');
    }
}
