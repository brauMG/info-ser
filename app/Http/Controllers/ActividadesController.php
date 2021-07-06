<?php

namespace App\Http\Controllers;
use App\Areas;
use App\Etapas;
use App\Mail\ActivitiesTimeline;
use App\Mail\AdviceActivity;
use App\Mail\AdviceActivityStatus;
use App\RolProyecto;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Area;
use App\Compania;
use App\Actividad;
use App\Fase;
use App\Proyecto;
use App\Status;
use Illuminate\Support\Facades\Mail;
use PDF;

class ActividadesController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        if (Auth::user()->Clave_Rol == 4) {
            $rol = Auth::user()->Clave_Rol;
            $companyId = Auth::user()->Clave_Compania;
            $datetime = Carbon::now();
            $datetime->setTimezone('GMT-7');
            $date = $datetime->toDateString();
            $time = $datetime->toTimeString();
            $compania = Compania::where('Clave', Auth::user()->Clave_Compania)->first();
            $actividad = DB::table('Actividades')
                ->leftJoin('Companias', 'Actividades.Clave_Compania', '=', 'Companias.Clave')
                ->leftJoin('Proyectos', 'Actividades.Clave_Proyecto', '=', 'Proyectos.Clave')
                ->leftJoin('Usuarios', 'Actividades.Clave_Usuario', '=', 'Usuarios.Clave')
                ->leftJoin('Etapas', 'Actividades.Clave_Etapa', '=', 'Etapas.Clave')
                ->leftJoin('Fases', 'Actividades.Clave_Fase', '=', 'Fases.Clave')
                ->select('Actividades.Clave as Clave', 'Companias.Descripcion as Compania', 'Proyectos.Descripcion as Proyecto', 'Etapas.Descripcion as Etapa', 'Fases.Descripcion as Fase', 'Actividades.Descripcion', 'Actividades.Fecha_Vencimiento', 'Actividades.Hora_Vencimiento', 'Actividades.Fecha_Revision', 'Actividades.Hora_Revision', 'Actividades.Decision', 'Usuarios.nombres as Usuario', 'Actividades.FechaCreacion', 'Actividades.Estado')
                ->where('Actividades.Clave_Compania', '=', $companyId)
                ->get();
            return view('Admin.Actividades.index', ['actividad' => $actividad, 'compania' => $compania, 'date' => $date, 'time' => $time, 'rol' => $rol]);
        }

        if (Auth::user()->Clave_Rol == 3) {
            $rol = Auth::user()->Clave_Rol;
            $companyId = Auth::user()->Clave_Compania;
            $datetime = Carbon::now();
            $datetime->setTimezone('GMT-7');
            $date = $datetime->toDateString();
            $time = $datetime->toTimeString();
            $compania = Compania::where('Clave', Auth::user()->Clave_Compania)->first();

            $actividad = DB::table('Actividades')
                ->leftJoin('Companias', 'Actividades.Clave_Compania', '=', 'Companias.Clave')
                ->leftJoin('RolesProyectos', 'Actividades.Clave_Proyecto', '=', 'RolesProyectos.Clave_Proyecto')
                ->leftJoin('Proyectos', 'RolesProyectos.Clave_Proyecto', '=', 'Proyectos.Clave')
                ->leftJoin('Usuarios', 'Actividades.Clave_Usuario', '=', 'Usuarios.Clave')
                ->leftJoin('Etapas', 'Actividades.Clave_Etapa', '=', 'Etapas.Clave')
                ->leftJoin('Fases', 'Actividades.Clave_Fase', '=', 'Fases.Clave')
                ->select('Actividades.Clave as Clave', 'Companias.Descripcion as Compania', 'Proyectos.Descripcion as Proyecto', 'Etapas.Descripcion as Etapa', 'Fases.Descripcion as Fase', 'Actividades.Descripcion', 'Actividades.Fecha_Vencimiento', 'Actividades.Hora_Vencimiento', 'Actividades.Fecha_Revision', 'Actividades.Hora_Revision', 'Actividades.Decision', 'Usuarios.nombres as Usuario', 'Actividades.FechaCreacion', 'Actividades.Estado')
                ->where('Actividades.Clave_Compania', '=', $companyId)
                ->where('RolesProyectos.Clave_Usuario', Auth::user()->Clave)
                ->get();
            return view('Admin.Actividades.index', ['actividad' => $actividad, 'compania' => $compania, 'date' => $date, 'time' => $time, 'rol' => $rol]);
        }
    }

    public function edit($id){
        $actividad=Actividad::where('Clave', $id)->get()->toArray();
        $proyectos=Proyecto::all();
        $fases=Fase::all();
        $status=Status::all();
        return view('Admin.Actividades.edit',compact('actividad','proyectos','fases', 'status'));
    }

    public function editStatus($id) {
        $actividadEstado=Actividad::where('Clave', $id)->get()->toArray();
        $actividadEstado = $actividadEstado[0];
        $estados= [
            1,
            2
        ];
        return view('Admin.Actividades.editStatus', compact('estados', 'actividadEstado'));
    }

    public function updateStatus(Request $request, $Clave){
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $time = $datetime->toTimeString();
        $status = $request->validate([
            'status' => ['required']
        ]);

        Actividad::where('Clave', $Clave)->update([
            'Estado' => $status['status'],
            'Fecha_Revision' => $date,
            'Hora_Revision' => $time
        ]);

        $actity = Actividad::where('Clave', $Clave)->get()->toArray();
        $actity = $actity[0];

        // DATOS DEL CORREO
        $user = Auth::user()->Nombres;
        $activityName = $actity['Descripcion'];
        $date = $actity['Fecha_Vencimiento'];
        $time = $actity['Hora_Vencimiento'];
        $status = $actity['Estado'];
        $project = Proyecto::where('Clave', $actity['Clave_Proyecto'])->get();
        $projectId = $project[0]->Clave;
        $project = $project[0]->Descripcion;
        $phase = Fase::where('Clave', $actity['Clave_Fase'])->get();
        $phase = $phase[0]->Descripcion;
        $stage = Etapas::where('Clave', $actity['Clave_Etapa'])->get();
        $stage = $stage[0]->Descripcion;

        //A QUIEN DIRIGIR EL CORREO
        $emailsAdmins = User::where('Clave_Compania', Auth::user()->Clave_Compania)->where('Clave_Rol', 2)->where('envio_de_correo', true)->get();
        $emailsAdmins = $emailsAdmins->pluck('email');
        $emailsPMOs = User::where('Clave_Compania', Auth::user()->Clave_Compania)->where('Clave_Rol', 4)->where('envio_de_correo', true)->get();
        $emailsPMOs = $emailsPMOs->pluck('email');
        $emailsUsers = DB::table('Usuarios')
            ->leftJoin('RolesProyectos', 'Usuarios.Clave', 'RolesProyectos.Clave_Usuario')
            ->select('Usuarios.email')
            ->where('RolesProyectos.Clave_Proyecto', $projectId)
            ->where('Usuarios.envio_de_correo', 1)
            ->where('Usuarios.Clave_Rol', 3)
            ->get();
        $emailsUsers = $emailsUsers->pluck('email');

        //ENVIO DE CORREOS
        foreach ($emailsAdmins as $email){
            Mail::to($email)->queue(new AdviceActivityStatus($user, $activityName, $date, $time, $status, $project, $phase, $stage));
        }
        foreach ($emailsPMOs as $email){
            Mail::to($email)->queue(new AdviceActivityStatus($user, $activityName, $date, $time, $status, $project, $phase, $stage));
        }
        foreach ($emailsUsers as $email){
            Mail::to($email)->queue(new AdviceActivityStatus($user, $activityName, $date, $time, $status, $project, $phase, $stage));
        }

        return redirect('/Admin/Actividades')->with('mensaje', "El estado de la revisión fue actualizado correctamente");
    }

    public function type($id){
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $proyectoID = $id;
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $etapas = Etapas::where('Clave_Proyecto', $proyectoID)->where('Fecha_Vencimiento', '>', $date)->get();
        return view('Admin.Actividades.type',compact('proyectoID', 'compania', 'etapas'));
    }

    public function new(Request $request, $proyectoID){
        $etapa = $request->input('etapa');
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $companiaId=Auth::user()->Clave_Compania;
        $usuarioId=Auth::user()->Clave;

        return view('Admin.Actividades.new',compact('etapa','proyectoID', 'companiaId', 'usuarioId', 'compania'));
    }

    public function store(Request $request){
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $etapa = $request->input('etapa');
        $etapaData = Etapas::where('Clave', $etapa)->first();

        $companiaId= $request->input('compania');
        $proyectoId= $request->input('proyecto');
        $usuarioId= $request->input('usuario');

        $actividad = $request->validate([
            'descripcion' => ['required', 'string', 'max:500150'],
            'decision' => ['required', 'string', 'max:500150']
        ]);

        $actity = Actividad::create([
            'Clave_Compania' => $companiaId,
            'Clave_Proyecto' => $proyectoId,
            'Descripcion' => $actividad['descripcion'],
            'Decision' => $actividad['decision'],
            'FechaCreacion' => $date,
            'Estado' => 0,
            'Clave_Usuario' => $usuarioId,
            'Clave_Fase' => $etapaData->Clave_Fase,
            'Clave_Etapa' => $etapaData->Clave,
            'Fecha_Vencimiento' => $etapaData->Fecha_Vencimiento,
            'Hora_Vencimiento' => $etapaData->Hora_Vencimiento,
        ]);

        // DATOS DEL CORREO
        $user = Auth::user()->Nombres;
        $area = Auth::user()->Clave_Area;
        $area = Areas::where('Clave', $area)->get();
        $InArea = $area[0]->Descripcion;
        $activityName = $actity->Descripcion;
        $date = $actity->Fecha_Vencimiento;
        $time = $actity->Hora_Vencimiento;
        $project = Proyecto::where('Clave', $actity->Clave_Proyecto)->get();
        $projectId = $project[0]->Clave;
        $project = $project[0]->Descripcion;
        $phase = Fase::where('Clave', $actity->Clave_Fase)->get();
        $phase = $phase[0]->Descripcion;
        $stage = Etapas::where('Clave', $actity->Clave_Etapa)->get();
        $stage = $stage[0]->Descripcion;

        //A QUIEN DIRIGIR EL CORREO
        $emailsAdmins = User::where('Clave_Compania', Auth::user()->Clave_Compania)->where('Clave_Rol', 2)->where('envio_de_correo', true)->get();
        $emailsAdmins = $emailsAdmins->pluck('email');
        $emailsPMOs = User::where('Clave_Compania', Auth::user()->Clave_Compania)->where('Clave_Rol', 4)->where('envio_de_correo', true)->get();
        $emailsPMOs = $emailsPMOs->pluck('email');
        $emailsUsers = DB::table('Usuarios')
            ->leftJoin('RolesProyectos', 'Usuarios.Clave', 'RolesProyectos.Clave_Usuario')
            ->select('Usuarios.email')
            ->where('RolesProyectos.Clave_Proyecto', $projectId)
            ->where('Usuarios.envio_de_correo', 1)
            ->where('Usuarios.Clave_Rol', 3)
            ->get();
        $emailsUsers = $emailsUsers->pluck('email');

        //ENVIO DE CORREOS
        foreach ($emailsAdmins as $email){
            Mail::to($email)->queue(new AdviceActivity($user, $InArea, $activityName, $date, $time, $project, $phase, $stage));
        }
        foreach ($emailsPMOs as $email){
            Mail::to($email)->queue(new AdviceActivity($user, $InArea, $activityName, $date, $time, $project, $phase, $stage));
        }
        foreach ($emailsUsers as $email){
            Mail::to($email)->queue(new AdviceActivity($user, $InArea, $activityName, $date, $time, $project, $phase, $stage));
        }

        return redirect('/Admin/Actividades')->with('mensaje', "Nueva actividad agregada correctamente");
    }
    public function delete($id){
        $actividad = Actividad::find($id);

        $actividad->delete();
        return response()->json(['error'=>false]);
    }
    public function update(Request $request){
        $actividad = Actividad::find($request->clave);
        $actividad->Clave_Compania=$request->compania;
        $actividad->Clave_Proyecto = $request->proyecto;
        $actividad->Clave_Fase = $request->fase;
        $actividad->Descripcion = $request->descripcion;
        $actividad->FechaAccion = $request->fechaAccion;
        $actividad->Decision = $request->decision;
        $actividad->Clave_Status = $request->status;
        $actividad->Clave_Proyecto = $request->proyecto;
        $actividad->save();
        return response()->json(['actividad'=>$actividad]);
    }

    public function preparePdf(Request $request) {
        $etapas = DB::table('Etapas')
            ->leftJoin('Proyectos', 'Etapas.Clave_Proyecto', '=', 'Proyectos.Clave')
            ->select('Etapas.Clave as Clave', 'Proyectos.Descripcion as Proyecto', 'Etapas.Descripcion as Etapa')
            ->where('Etapas.Clave_Compania', '=', Auth::user()->Clave_Compania)
            ->get();
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $proyectos = Proyecto::where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $fases = Fase::where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $usuarios = User::where('Clave_Compania', Auth::user()->Clave_Compania)->where('Clave_Rol', 3)->orWhere('Clave_Rol', 4)->get();
        $estados = [
            0,
            1,
            2
        ];
        return view('Admin.Actividades.prepare', compact('proyectos', 'fases', 'usuarios', 'etapas', 'estados', 'compania'));
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

        $actividades = DB::table('Actividades')
            ->join('Companias', 'Actividades.Clave_Compania', '=', 'Companias.Clave')
            ->where('Actividades.Clave_Compania', '=', Auth::user()->Clave_Compania)
            ->join('Proyectos', 'Actividades.Clave_Proyecto', '=', 'Proyectos.Clave')
            ->where(function($query) use ($proyectos, $request) {
                if ($proyectos != null) {
                    $query->whereIn('Actividades.Clave_Proyecto', $proyectos);
                }
            })
            ->join('Usuarios', 'Actividades.Clave_Usuario', '=', 'Usuarios.Clave')
            ->where(function($query) use ($usuarios, $request) {
                if ($usuarios != null) {
                    $query->whereIn('Actividades.Clave_Usuario', $usuarios);
                }
            })
            ->join('Etapas', 'Actividades.Clave_Etapa', '=', 'Etapas.Clave')
            ->where(function($query) use ($etapas, $request) {
                if ($etapas != null) {
                    $query->whereIn('Actividades.Clave_Etapa', $etapas);
                }
            })
            ->join('Fases', 'Actividades.Clave_Fase', '=', 'Fases.Clave')
            ->where(function($query) use ($fases, $request) {
                if ($fases != null) {
                    $query->whereIn('Actividades.Clave_Fase', $fases);
                }
            })
            ->where(function($query) use ($desde, $request) {
                if ($desde != null) {
                    $query->whereDate('Actividades.FechaCreacion', '>=', $desde);
                }
            })
            ->where(function($query) use ($hasta, $request) {
                if ($hasta != null) {
                    $query->whereDate('Actividades.FechaCreacion', '<=', $hasta);
                }
            })
            ->where(function($query) use ($estados, $request) {
                if ($estados != null) {
                    $query->whereIn('Actividades.Estado', $estados);
                }
            })
            ->select('Actividades.*', 'Etapas.Descripcion as Etapa', 'Companias.Descripcion as Compania', 'Fases.Descripcion as Fase', 'Usuarios.Nombres as Usuario', 'Proyectos.Descripcion as Proyecto')
            ->get();

        $pdf = PDF::loadView('pdf.activities', compact('actividades', 'date', 'time'));

        return $pdf->download('actividades.pdf');
    }
}
