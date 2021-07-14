<?php

namespace App\Http\Controllers;

//use App\Mail\ActivitiesTimeline;
//use App\Mail\AdviceActivity;
//use App\Mail\AdviceActivityStatus;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\PDF;

use App\Models\Areas;
use App\Models\Etapas;
use App\Models\RolProyecto;
use App\Models\User;
use App\Models\Companias;
use App\Models\Actividad;
use App\Models\Fase;
use App\Models\Proyecto;
use App\Models\Status;
use Illuminate\Support\Facades\Mail;

class ActividadesController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        if (Auth::user()->id_rol == 4) {
            $rol = Auth::user()->id_rol;
            $companyId = Auth::user()->id_compania;
            $datetime = Carbon::now();
            $datetime->setTimezone('GMT-7');
            $date = $datetime->toDateString();
            $time = $datetime->toTimeString();
            $compania = Companias::where('id', Auth::user()->id_compania)->first();
            $actividad = DB::table('actividades')
                ->leftJoin('companias', 'actividades.id_compania', '=', 'companias.id')
                ->leftJoin('proyectos', 'actividades.id_proyecto', '=', 'proyectos.id')
                ->leftJoin('usuarios', 'actividades.id_usuario', '=', 'usuarios.id')
                ->leftJoin('etapas', 'actividades.id_etapa', '=', 'etapas.id')
                ->leftJoin('fases', 'actividades.id_fase', '=', 'fases.id')
                ->select('actividades.id as id', 'companias.descripcion as compania', 'proyectos.descripcion as proyecto', 'etapas.descripcion as etapa', 'fases.descripcion as fase', 'actividades.descricion as descripcion', 'actividades.fecha_vencimiento', 'actividades.hora_vencimiento', 'actividades.fecha_revision', 'actividades.hora_revision', 'actividades.decision', 'usuarios.nombres as usuario', 'actividades.fecha_creacion', 'actividades.estado')
                ->where('actividades.id_compania', '=', $companyId)
                ->get();

            return view('pages.actividades.index', ['actividad' => $actividad, 'compania' => $compania, 'date' => $date, 'time' => $time, 'rol' => $rol]);
        }

        if (Auth::user()->id_rol == 3) {
            $rol = Auth::user()->id_rol;
            $companyId = Auth::user()->id_compania;
            $datetime = Carbon::now();
            $datetime->setTimezone('GMT-7');
            $date = $datetime->toDateString();
            $time = $datetime->toTimeString();
            $compania = Companias::where('id', Auth::user()->id_compania)->first();

            $actividad = DB::table('actividades')
                ->leftJoin('companias', 'actividades.id_compania', '=', 'companias.id')
                ->leftJoin('roles_proyectos', 'actividades.id_proyecto', '=', 'roles_proyectos.id_proyecto')
                ->leftJoin('proyectos', 'roles_proyectos.id_proyecto', '=', 'proyectos.id')
                ->leftJoin('usuarios', 'actividades.id_usuario', '=', 'usuarios.id')
                ->leftJoin('etapas', 'actividades.id_etapa', '=', 'etapas.id')
                ->leftJoin('fases', 'actividades.id_fase', '=', 'fases.id')
                ->select('actividades.id as id', 'companias.descripcion as compania', 'proyectos.descripcion as proyecto', 'etapas.descripcion as etapa', 'fases.descripcion as fase', 'actividades.descricion as descripcion', 'actividades.fecha_vencimiento', 'actividades.hora_vencimiento', 'actividades.fecha_revision', 'actividades.hora_revision', 'actividades.decision', 'usuarios.nombres as usuario', 'actividades.fecha_creacion', 'actividades.estado')
                ->where('actividades.id_compania', '=', $companyId)
                ->where('roles_proyectos.id_usuario', Auth::user()->id)
                ->get();
            return view('pages.actividades.index', ['actividad' => $actividad, 'compania' => $compania, 'date' => $date, 'time' => $time, 'rol' => $rol]);
        }
    }

    public function edit($id){
        $actividad=Actividad::where('id', $id)->get()->toArray();
        $proyectos=Proyecto::all();
        $fases=Fase::all();
        $status=Status::all();
        return view('pages.actividades.edit',compact('actividad','proyectos','fases', 'status'));
    }

    public function editStatus($id) {
        $actividadEstado=Actividad::where('id', $id)->get()->toArray();
        $actividadEstado = $actividadEstado[0];
        $estados= [
            1,
            2
        ];
        return view('pages.actividades.editStatus', compact('estados', 'actividadEstado'));
    }

    public function updateStatus(Request $request, $id){
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $time = $datetime->toTimeString();
        $status = $request->validate([
            'status' => ['required']
        ]);

        Actividad::where('id', $id)->update([
            'estado' => $status['status'],
            'fecha_revision' => $date,
            'hora_revision' => $time
        ]);

        $actity = Actividad::where('id', $id)->get()->toArray();
        $actity = $actity[0];

        // DATOS DEL CORREO
//        $user = Auth::user()->nombres;
//        $activityName = $actity['descricion'];
//        $date = $actity['fecha_vencimiento'];
//        $time = $actity['hora_revision'];
//        $status = $actity['estado'];
//        $project = Proyecto::where('id', $actity['id_proyecto'])->get();
//        $projectId = $project[0]->id;
//        $project = $project[0]->descripcion;
//        $phase = Fase::where('id', $actity['id_fase'])->get();
//        $phase = $phase[0]->descripcion;
//        $stage = Etapas::where('id', $actity['id_etapa'])->get();
//        $stage = $stage[0]->descripcion;

        //A QUIEN DIRIGIR EL CORREO
//        $emailsAdmins = User::where('id_compania', Auth::user()->id_compania)->where('id_rol', 2)->where('envio_de_correo', true)->get();
//        $emailsAdmins = $emailsAdmins->pluck('email');
//        $emailsPMOs = User::where('id_compania', Auth::user()->id_compania)->where('id_rol', 4)->where('envio_de_correo', true)->get();
//        $emailsPMOs = $emailsPMOs->pluck('email');
//        $emailsUsers = DB::table('usuarios')
//            ->leftJoin('roles_proyectos', 'usuarios.id', 'roles_proyectos.id_usuario')
//            ->select('usuarios.email')
//            ->where('roles_proyectos.id_proyectos', $projectId)
//            ->where('usuarios.envio_de_correo', 1)
//            ->where('usuarios.id_rol', 3)
//            ->get();
//        $emailsUsers = $emailsUsers->pluck('email');

        //ENVIO DE CORREOS
//        foreach ($emailsAdmins as $email){
//            Mail::to($email)->queue(new AdviceActivityStatus($user, $activityName, $date, $time, $status, $project, $phase, $stage));
//        }
//        foreach ($emailsPMOs as $email){
//            Mail::to($email)->queue(new AdviceActivityStatus($user, $activityName, $date, $time, $status, $project, $phase, $stage));
//        }
//        foreach ($emailsUsers as $email){
//            Mail::to($email)->queue(new AdviceActivityStatus($user, $activityName, $date, $time, $status, $project, $phase, $stage));
//        }

        return redirect('/actividades')->with('mensaje', "El estado de la revisión fue actualizado correctamente");
    }

    public function type($id){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $proyectoID = $id;
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $etapas = Etapas::where('id_proyecto', $proyectoID)->where('fecha_vencimiento', '>', $date)->get();
        return view('pages.actividades.type',compact('proyectoID', 'compania', 'etapas'));
    }

    public function new(Request $request, $proyectoID){
        $etapa = $request->input('etapa');
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $companiaId=Auth::user()->id_compania;
        $usuarioId=Auth::user()->id;

        return view('pages.actividades.new',compact('etapa','proyectoID', 'companiaId', 'usuarioId', 'compania'));
    }

    public function store(Request $request){
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $etapa = $request->input('etapa');
        $etapaData = Etapas::where('id', $etapa)->first();

        $companiaId= $request->input('compania');
        $proyectoId= $request->input('proyecto');
        $usuarioId= $request->input('usuario');

        $actividad = $request->validate([
            'descripcion' => ['required', 'string', 'max:500150'],
            'decision' => ['required', 'string', 'max:500150']
        ]);

        $actity = Actividad::create([
            'id_compania' => $companiaId,
            'id_proyecto' => $proyectoId,
            'descricion' => $actividad['descripcion'],
            'decision' => $actividad['decision'],
            'fecha_creacion' => $date,
            'estado' => 0,
            'id_usuario' => $usuarioId,
            'id_fase' => $etapaData->id_fase,
            'id_etapa' => $etapaData->id,
            'fecha_vencimiento' => $etapaData->fecha_vencimiento,
            'hora_vencimiento' => $etapaData->hora_vencimiento,
        ]);

        // DATOS DEL CORREO
//        $user = Auth::user()->nombres;
//        $area = Auth::user()->id_area;
//        $area = Areas::where('id', $area)->get();
//        $InArea = $area[0]->descripcion;
//        $activityName = $actity->descricion;
//        $date = $actity->fecha_vencimiento;
//        $time = $actity->hora_vencimiento;
//        $project = Proyecto::where('id', $actity->id_proyecto)->get();
//        $projectId = $project[0]->id;
//        $project = $project[0]->descripcion;
//        $phase = Fase::where('id', $actity->id_fase)->get();
//        $phase = $phase[0]->descripcion;
//        $stage = Etapas::where('id', $actity->id_etapa)->get();
//        $stage = $stage[0]->descripcion;

        //A QUIEN DIRIGIR EL CORREO
//        $emailsAdmins = User::where('id_compania', Auth::user()->id_compania)->where('id_rol', 2)->where('envio_de_correo', true)->get();
//        $emailsAdmins = $emailsAdmins->pluck('email');
//        $emailsPMOs = User::where('id_compania', Auth::user()->id_compania)->where('id_rol', 4)->where('envio_de_correo', true)->get();
//        $emailsPMOs = $emailsPMOs->pluck('email');
//        $emailsUsers = DB::table('usuarios')
//            ->leftJoin('roles_proyectos', 'usuarios.id', 'roles_proyectos.id_usuario')
//            ->select('usuarios.email')
//            ->where('roles_proyectos.id_proyecto', $projectId)
//            ->where('usuarios.envio_de_correo', 1)
//            ->where('usuarios.id_rol', 3)
//            ->get();
//        $emailsUsers = $emailsUsers->pluck('email');

        //ENVIO DE CORREOS
//        foreach ($emailsAdmins as $email){
//            Mail::to($email)->queue(new AdviceActivity($user, $InArea, $activityName, $date, $time, $project, $phase, $stage));
//        }
//        foreach ($emailsPMOs as $email){
//            Mail::to($email)->queue(new AdviceActivity($user, $InArea, $activityName, $date, $time, $project, $phase, $stage));
//        }
//        foreach ($emailsUsers as $email){
//            Mail::to($email)->queue(new AdviceActivity($user, $InArea, $activityName, $date, $time, $project, $phase, $stage));
//        }

        return redirect('/actividades')->with('mensaje', "Nueva actividad agregada correctamente");
    }
    public function delete($id){
        $actividad = Actividad::find($id);

        $actividad->delete();
        return response()->json(['error'=>false]);
    }

    public function preparePdf(Request $request) {
        $etapas = DB::table('etapas')
            ->leftJoin('proyectos', 'etapas.id_proyecto', '=', 'proyectos.id')
            ->select('etapas.id as id', 'proyectos.descripcion as proyecto', 'etapas.descripcion as etapa')
            ->where('etapas.id_compania', '=', Auth::user()->id_compania)
            ->get();
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $proyectos = Proyecto::where('id_compania', Auth::user()->id_compania)->get();
        $fases = Fase::where('id_compania', Auth::user()->id_compania)->get();
        $usuarios = User::where('id_compania', Auth::user()->id_compania)->where('id_rol', 3)->orWhere('id_rol', 4)->get();
        $estados = [
            0,
            1,
            2
        ];
        return view('pages.actividades.prepare', compact('proyectos', 'fases', 'usuarios', 'etapas', 'estados', 'compania'));
    }

    public function exportPdf(Request $request)
    {
        $proyectos = $request->input('proyectos');
        $etapas = $request->input('etapas');
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $usuarios = $request->input('usuarios');
        $fases = $request->input('fases');
        $estados = $request->input('estados');
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $time = $datetime->toTimeString();

        $actividades = DB::table('actividades')
            ->join('companias', 'actividades.id_compania', '=', 'companias.id')
            ->where('actividades.id_compania', '=', Auth::user()->id_compania)
            ->join('proyectos', 'actividades.id_proyecto', '=', 'proyectos.id')
            ->where(function($query) use ($proyectos, $request) {
                if ($proyectos != null) {
                    $query->whereIn('actividades.id_proyecto', $proyectos);
                }
            })
            ->join('usuarios', 'actividades.id_usuario', '=', 'usuarios.id')
            ->where(function($query) use ($usuarios, $request) {
                if ($usuarios != null) {
                    $query->whereIn('actividades.id_usuario', $usuarios);
                }
            })
            ->join('etapas', 'actividades.id_etapa', '=', 'etapas.id')
            ->where(function($query) use ($etapas, $request) {
                if ($etapas != null) {
                    $query->whereIn('actividades.id_etapa', $etapas);
                }
            })
            ->join('fases', 'actividades.id_fase', '=', 'fases.id')
            ->where(function($query) use ($fases, $request) {
                if ($fases != null) {
                    $query->whereIn('actividades.id_fase', $fases);
                }
            })
            ->where(function($query) use ($desde, $request) {
                if ($desde != null) {
                    $query->whereDate('actividades.fecha_creacion', '>=', $desde);
                }
            })
            ->where(function($query) use ($hasta, $request) {
                if ($hasta != null) {
                    $query->whereDate('actividades.fecha_creacion', '<=', $hasta);
                }
            })
            ->where(function($query) use ($estados, $request) {
                if ($estados != null) {
                    $query->whereIn('actividades.estado', $estados);
                }
            })
            ->select('actividades.*', 'etapas.descripcion as etapa', 'companias.descripcion as compania', 'fases.descripcion as fase', 'usuarios.nombres as usuario', 'proyectos.descripcion as proyecto')
            ->get();

        $pdf = PDF::loadView('pdf.activities', compact('actividades', 'date', 'time'));

        return $pdf->download('actividades.pdf');
    }
}
