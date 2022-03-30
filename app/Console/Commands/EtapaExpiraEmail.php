<?php

namespace App\Console\Commands;

use App\Mail\AdviceActivity;
use App\Mail\WarningStage;
use App\Models\Etapas;
use App\Models\RolProyecto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EtapaExpiraEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $current_date = Carbon::now();
        $stages = Etapas::where('fecha_vencimiento', '>', Carbon::now())->get();
        $projects = [];
        $i = 0;
        foreach ($stages as $stage) {
            $projects [$i] = [
                'proyecto' => $stage->id_proyecto,
                'etapa' => $stage->descripcion,
                'vence' => $stage->fecha_vencimiento
            ];
            $i++;
        }

        $i = 0;
        $emailsUser = [];
        foreach ($projects as $project) {
            $user = DB::table('roles_proyectos')
                ->leftJoin('usuarios', 'roles_proyectos.id_usuario', 'usuarios.id')
                ->select('usuarios.email')
                ->where('roles_proyectos.id_proyecto', $project['proyecto'])
                ->first();

            $stage_name = $project['etapa'];
            if (isset($user->email)) {
                $emailsUser [$i] = [
                    'email' => $user->email,
                    'etapa' => $stage_name,
                    'vence' => $project['vence']
                ];
                $i++;
            }
        }

        $i = 0;
        $emailsPMO = [];

        foreach ($projects as $project) {
            $users = User::where('id_rol', [4, 2])->get();

            $stage_name = $project['etapa'];
            foreach ($users as $user) {
                $emailsPMO [$i] = [
                    'email' => $user->email,
                    'etapa' => $stage_name,
                    'vence' => $project['vence']
                ];
                $i++;
            }
        }

        foreach($emailsUser as $emailUser) {
            if(Carbon::parse($emailUser[0]['vence'])->diffInDays(Carbon::now()) == 2){
                Mail::to($emailUser[0]['email'])->queue(new WarningStage($emailsUser[0]['etapa'], $emailsUser[0]['vence']));
            }
        }

        foreach($emailsUser as $emailUser) {
            if(Carbon::parse($emailUser[0]['vence'])->diffInDays(Carbon::now()) == 2){
                Mail::to($emailUser[0]['email'])->queue(new WarningStage($emailsUser[0]['etapa'], $emailsUser[0]['vence']));
            }
        }
    }
}
