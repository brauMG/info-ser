<?php

namespace App\Console\Commands;

use App\Actividad;
use App\Areas;
use App\Compania;
use App\Etapas;
use App\Fase;
use App\Mail\ActivitiesTimeline;
use App\Proyecto;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendActivitiesTimeline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SendActivitiesTimeline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the email when the timeline is near';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $today = Carbon::today();
        $today = $today->toDateString();
        $tomorrow = Carbon::tomorrow();
        $tomorrow = $tomorrow->toDateString();

        $companies = Compania::all();
        $companiesIds = $companies->pluck('Clave');

        foreach ($companiesIds as $id) {
            $activities = DB::table('Actividades')
                ->leftJoin('Proyectos', 'Actividades.Clave_Proyecto', 'Proyectos.Clave')
                ->where('Actividades.Clave_Compania', $id)
                ->where('Actividades.Fecha_Vencimiento', $today)
                ->orWhere('Actividades.Fecha_Vencimiento', $tomorrow)
                ->where('Actividades.Estado', 0)
                ->select('Actividades.Descripcion', 'Actividades.Decision', 'Actividades.Fecha_Vencimiento', 'Actividades.Hora_Vencimiento', 'Proyectos.Descripcion as Proyecto')
                ->get();

            if (count($activities) > 0) {
                //A QUIEN DIRIGIR EL CORREO
                $emailsAdmins = User::where('Clave_Compania', $id)->where('Clave_Rol', 2)->where('envio_de_correo', true)->get();
                $emailsAdmins = $emailsAdmins->pluck('email');
                $emailsPMOs = User::where('Clave_Compania', $id)->where('Clave_Rol', 4)->where('envio_de_correo', true)->get();
                $emailsPMOs = $emailsPMOs->pluck('email');

                //ENVIO DE CORREOS
                foreach ($emailsAdmins as $email) {
                    Mail::to($email)->queue(new ActivitiesTimeline($activities));
                }
                foreach ($emailsPMOs as $email) {
                    Mail::to($email)->queue(new ActivitiesTimeline($activities));
                }
            }
        }
    }
}
