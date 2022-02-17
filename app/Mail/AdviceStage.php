<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdviceStage extends Mailable
{
    public $usuario;
    public $fecha;
    public $hora;
    public $proyecto;
    public $etapa;
    public $subject = "Nueva Etapa Registrada En Proyecto De SER";

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $date, $time, $project, $stage)
    {
        $this->usuario = $user;
        $this->fecha = $date;
        $this->hora = $time;
        $this->proyecto = $project;
        $this->etapa = $stage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.advice-stage');
    }
}
