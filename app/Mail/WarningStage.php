<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WarningStage extends Mailable
{
    public $vence_;
    public $etapa;
    public $subject = "Nueva Etapa Registrada En Proyecto De SER";

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vence, $etapa)
    {
        $this->vence = $vence;
        $this->etapa = $etapa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.advice-stage')->with(
            [
                'vence'=>$this->vence,
                'etapa'=>$this->etapa,
            ]
        );;
    }
}
