<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdviceActivity extends Mailable
{
    public $usuario;
    public $area;
    public $actividad;
    public $fecha;
    public $hora;
    public $proyecto;
    public $fase;
    public $etapa;
    public $subject = "Nueva Actividad Registrada En SER";

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $InArea, $activityName, $date, $time, $project, $phase, $stage)
    {
        $this->usuario = $user;
        $this->area = $InArea;
        $this->actividad = $activityName;
        $this->fecha = $date;
        $this->hora = $time;
        $this->proyecto = $project;
        $this->fase = $phase;
        $this->etapa = $stage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.advice-activity');
    }
}
