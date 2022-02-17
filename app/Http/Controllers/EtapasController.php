<?php


namespace App\Http\Controllers;

//use App\Mail\AdviceActivity;
//use App\Mail\AdviceStage;

use App\Mail\AdviceStage;
use App\Models\Direccion;
use App\Models\Gerencia;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\Actividad;
use App\Models\Areas;
use App\Models\Companias;
use App\Models\Etapas;
use App\Models\Fase;
use App\Models\Proyecto;
use App\Models\User;


class EtapasController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        $rol = Auth::user()->id_rol;
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $time = $datetime->toTimeString();
        if (Auth::user()->id_rol == 4) {
            $gerencias = Gerencia::where('id_compania', Auth::user()->id_compania)->get();
        }
        if (Auth::user()->id_rol == 7) {
            $gerencias = Gerencia::where('id_gerente', Auth::user()->id)->get();
        }

        if (Auth::user()->id_rol == 4) {
            $etapa = DB::table('etapas')
                ->leftJoin('proyectos', 'etapas.id_proyecto', '=', 'proyectos.id')
                ->leftJoin('fases', 'etapas.id_fase', '=', 'fases.id')
                ->leftJoin('gerencias', 'gerencias.id', '=', 'proyectos.id_gerencia')
                ->select('gerencias.nombre as gerencia', 'etapas.id', 'proyectos.descripcion as proyecto', 'fases.descripcion as fase', 'etapas.descripcion', 'etapas.fecha_vencimiento', 'etapas.hora_vencimiento', 'etapas.created_at as creado')
                ->where('etapas.id_compania', '=', Auth::user()->id_compania)
                ->orderBy('creado', 'asc')
                ->get();
        }
        else {
            $etapa = DB::table('etapas')
                ->leftJoin('proyectos', 'etapas.id_proyecto', '=', 'proyectos.id')
                ->leftJoin('gerencias', 'gerencias.id', '=', 'proyectos.id_gerencia')
                ->leftJoin('fases', 'etapas.id_fase', '=', 'fases.id')
                ->select('gerencias.nombre as gerencia', 'etapas.id', 'proyectos.descripcion as proyecto', 'fases.descripcion as fase', 'etapas.descripcion', 'etapas.fecha_vencimiento', 'etapas.hora_vencimiento', 'etapas.created_at as creado')
                ->where('etapas.id_compania', '=', Auth::user()->id_compania)
                ->where('gerencias.id_gerente', Auth::user()->id)
                ->orderBy('creado', 'asc')
                ->get();
        }

        return view('pages.etapas.index',['gerencias' => $gerencias, 'rol' => $rol, 'etapa' => $etapa,'compania'=>$compania, 'date'=>$date, 'time'=>$time]);
    }

    public function sub_index($id){
        $estado = DB::table('proyectos')->leftJoin('estado', 'proyectos.id_estado', '=', 'estado.id')->where('proyectos.id', $id)->select('estado.activo')->get();
        $estado = $estado[0]->activo;
        $rol = Auth::user()->id_rol;
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $time = $datetime->toTimeString();
        if (Auth::user()->id_rol == 4 || Auth::user()->id_rol == 3) {
            $gerencias = Gerencia::where('id_compania', Auth::user()->id_compania)->get();
        }
        if (Auth::user()->id_rol == 7) {
            $gerencias = Gerencia::where('id_gerente', Auth::user()->id)->get();
        }

        if (Auth::user()->id_rol == 4) {
            $etapa = DB::table('etapas')
                ->leftJoin('proyectos', 'etapas.id_proyecto', '=', 'proyectos.id')
                ->leftJoin('fases', 'etapas.id_fase', '=', 'fases.id')
                ->leftJoin('gerencias', 'gerencias.id', '=', 'proyectos.id_gerencia')
                ->select('gerencias.nombre as gerencia', 'etapas.id', 'proyectos.descripcion as proyecto', 'fases.descripcion as fase', 'etapas.descripcion', 'etapas.fecha_vencimiento', 'etapas.hora_vencimiento', 'etapas.created_at as creado')
                ->where('etapas.id_compania', '=', Auth::user()->id_compania)
                ->where('etapas.id_proyecto', $id)
                ->orderBy('creado', 'asc')
                ->get();
        }
        else {
            $etapa = DB::table('etapas')
                ->leftJoin('proyectos', 'etapas.id_proyecto', '=', 'proyectos.id')
                ->leftJoin('gerencias', 'gerencias.id', '=', 'proyectos.id_gerencia')
                ->leftJoin('fases', 'etapas.id_fase', '=', 'fases.id')
                ->select('gerencias.nombre as gerencia', 'etapas.id', 'proyectos.descripcion as proyecto', 'fases.descripcion as fase', 'etapas.descripcion', 'etapas.fecha_vencimiento', 'etapas.hora_vencimiento', 'etapas.created_at as creado')
                ->where('etapas.id_compania', '=', Auth::user()->id_compania)
                ->where('gerencias.id_gerente', Auth::user()->id)
                ->where('etapas.id_proyecto', $id)
                ->orderBy('creado', 'asc')
                ->get();
        }

        return view('pages.proyectos.seeStage',['gerencias' => $gerencias, 'rol' => $rol, 'etapa' => $etapa,'compania'=>$compania, 'date'=>$date, 'time'=>$time, 'id_proyecto'=>$id, 'estado' => $estado]);
    }

    public function edit($id){
        $etapa=Etapas::where('id', $id)->get()->toArray();
        $etapaId = $etapa[0]['id'];
        $etapa = $etapa[0];
        $company = Companias::all();
        $etapaCompany = $etapa['id_compania'];
        $convertedtime = date("G:i:s", strtotime($etapa['hora_vencimiento']));
        return view('pages.etapas.edit', compact('etapa', 'etapaId', 'company', 'etapaCompany'));
    }

    public function new_stage(){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        if (Auth::user()->id_rol == 4) {
            $proyectos= Proyecto::where('id_compania',Auth::user()->id_compania)->get();
        }
        if (Auth::user()->id_rol == 7) {
            $proyectos= DB::table('proyectos')
                ->leftJoin('gerencias','gerencias.id','proyectos.id_gerencia')
                ->where('gerencias.id_gerente', Auth::user()->id)
                ->select('proyectos.*')
                ->get();
        }

        return view('pages.etapas.new', compact('proyectos'));
    }

    public function new_modal($proyecto_id){
        $id = $proyecto_id;
        return view('pages.proyectos.addStage', compact( 'id'));
    }

    public function store(Request $request){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();

        $etapa = $request->validate([
            'descripcion' => ['required', 'string', 'max:150'],
            'fechaV' => ['required', 'date'],
            'horaV' => ['required'],
            'proyecto' => ['required']
        ]);

        $proyecto = Proyecto::where('id', $etapa['proyecto'])->first();
        $fase = Fase::where('id', $proyecto->id_fase)->first();
        $faseId = $fase->id;
        $companyId = $fase->id_compania;

        $stage = Etapas::create([
            'descripcion' => $etapa['descripcion'],
            'fecha_vencimiento' => $etapa['fechaV'],
            'hora_vencimiento' => $etapa['horaV'],
            'id_proyecto' => $etapa['proyecto'],
            'id_compania' => $companyId,
            'id_fase' => $faseId
        ]);

        // DATOS DEL CORREO
        $user = Auth::user()->nombres;
        $stageName = $stage->descripcion;
        $date = $stage->fecha_vencimiento;
        $time = $stage->hora_vencimiento;
        $project = Proyecto::where('id', $stage->id_proyecto)->get();
        $projectId = $project[0]->id;
        $project = $project[0]->descripcion;

//        A QUIEN DIRIGIR EL CORREO
        $emailsAdmins = User::where('id_compania', Auth::user()->id_compania)->where('id_rol', 2)->where('envio_de_correo', true)->get();
        $emailsAdmins = $emailsAdmins->pluck('email');
        $emailsPMOs = User::where('id_compania', Auth::user()->id_compania)->where('id_rol', 4)->where('envio_de_correo', true)->get();
        $emailsPMOs = $emailsPMOs->pluck('email');
        $emailsUsers = DB::table('usuarios')
            ->leftJoin('roles_proyectos', 'usuarios.id', 'roles_proyectos.id_usuario')
            ->select('usuarios.email')
            ->where('roles_proyectos.id_proyecto', $projectId)
            ->where('usuarios.envio_de_correo', 1)
            ->where('usuarios.id_rol', 3)
            ->get();
        $emailsUsers = $emailsUsers->pluck('email');

//        ENVIO DE CORREOS
        foreach ($emailsAdmins as $email){
            Mail::to($email)->queue(new AdviceStage($user, $date, $time, $project, $stageName));
        }
        foreach ($emailsPMOs as $email){
            Mail::to($email)->queue(new AdviceStage($user, $date, $time, $project, $stageName));
        }
        foreach ($emailsUsers as $email){
            Mail::to($email)->queue(new AdviceStage($user, $date, $time, $project, $stageName));
        }

        return redirect('/etapas')->with('mensaje', "Nueva etapa agregada correctamente");
    }

    public function prepare($id){
        $etapa=Etapas::where('id', $id)->get()->toArray();
        $etapa = $etapa[0];
        return view('pages.etapas.delete', compact('etapa'));
    }

    public function delete($id){
        $etapa = Etapas::find($id);
        $etapa->delete();
        return redirect('/etapas')->with('mensajeAlert', "Etapa eliminada correctamente");
    }

    public function update(Request $request, $id){
        $etapa = Etapas::where('id', $id)->firstOrFail();
        $etapaNew = $request->input('descripcion');
        $fechaVNew = $request->input('fechaV');
        $horaVNew = $request->input('horaV');
        $convertedtime = date("G:i:s", strtotime($horaVNew));

        if ($etapaNew == $etapa->descripcion) {
            if ($fechaVNew == $etapa->fecha_vencimiento) {
                if ($convertedtime == $etapa->hora_vencimiento) {
                    return redirect('/etapas')->with('mensajeAlert', "No hubo datos nuevos");
                }
                else {
                    $etapa = $request->validate([
                        'horaV' => ['required']
                    ]);
                    Etapas::where('id', $id)->update([
                        'hora_vencimiento' => $etapa['horaV']
                    ]);
                    Actividad::where('id_etapa', $id)->update([
                        'hora_vencimiento' => $etapa['horaV']
                    ]);
                }
            }
            else if ($convertedtime == $etapa->hora_vencimiento){
                $etapa = $request->validate([
                    'fechaV' => ['required', 'date']
                ]);
                Etapas::where('id', $id)->update([
                    'fecha_vencimiento' => $etapa['fechaV']
                ]);
                Actividad::where('id_etapa', $id)->update([
                    'fecha_vencimiento' => $etapa['fechaV']
                ]);
            }
            else {
                $etapa = $request->validate([
                    'horaV' => ['required'],
                    'fechaV' => ['required', 'date']
                ]);
                Etapas::where('id', $id)->update([
                    'hora_vencimiento' => $etapa['horaV'],
                    'fecha_vencimiento' => $etapa['fechaV']
                ]);
                Actividad::where('id_etapa', $id)->update([
                    'hora_vencimiento' => $etapa['horaV'],
                    'fecha_vencimiento' => $etapa['fechaV']
                ]);
            }
        }
        else if ($fechaVNew == $etapa->fecha_vencimiento) {
            if ($convertedtime == $etapa->hora_vencimiento) {
                $etapa = $request->validate([
                    'descripcion' => ['required', 'string', 'max:150']
                ]);
                Etapas::where('id', $id)->update([
                    'descripcion' => $etapa['descripcion']
                ]);
            }
            else {
                $etapa = $request->validate([
                    'descripcion' => ['required', 'string', 'max:150'],
                    'horaV' => ['required']
                ]);
                Etapas::where('id', $id)->update([
                    'hora_vencimiento' => $etapa['horaV'],
                    'descripcion' => $etapa['descripcion']
                ]);
                Actividad::where('id_etapa', $id)->update([
                    'hora_vencimiento' => $etapa['horaV']
                ]);
            }
        }
        else if ($convertedtime == $etapa->Hora_Vencimiento) {
            $etapa = $request->validate([
                'horaV' => ['required']
            ]);
            Etapas::where('id', $id)->update([
                'hora_vencimiento' => $etapa['horaV']
            ]);
            Actividad::where('id_etapa', $id)->update([
                'hora_vencimiento' => $etapa['horaV']
            ]);
        }
        else {
            $etapa = $request->validate([
                'descripcion' => ['required', 'string', 'max:150'],
                'horaV' => ['required'],
                'fechaV' => ['required', 'date']
            ]);
            Etapas::where('id', $id)->update([
                'hora_vencimiento' => $etapa['horaV'],
                'fecha_vencimiento' => $etapa['fechaV'],
                'descripcion' => $etapa['descripcion']
            ]);
            Actividad::where('id_etapa', $id)->update([
                'hora_vencimiento' => $etapa['horaV'],
                'fecha_vencimiento' => $etapa['fechaV']
            ]);
        }
        return redirect('/etapas')->with('mensaje', "La etapa fue editada correctamente");
    }

    public function preparePdf(Request $request) {
        $rol = Auth::user()->id_rol;

        if ($rol == 2 || $rol == 4 || $rol == 5) {
            $etapas = DB::table('etapas')
                ->leftJoin('proyectos', 'etapas.id_proyecto', '=', 'proyectos.id')
                ->select('etapas.id as id', 'proyectos.descripcion as proyecto', 'etapas.descripcion as etapa')
                ->where('proyectos.id_compania', '=', Auth::user()->id_compania)
                ->get();
            $compania = Companias::where('id', Auth::user()->id_compania)->first();
            $proyectos = Proyecto::where('id_compania', Auth::user()->id_compania)->get();
            $fases = Fase::where('id_compania', Auth::user()->id_compania)->get();
            $direcciones = Direccion::where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = Gerencia::where('id_compania', Auth::user()->id_compania)->get();
        }
        if ($rol == 6) {
            $etapas = DB::table('etapas')
                ->leftJoin('proyectos', 'etapas.id_proyecto', '=', 'proyectos.id')
                ->select('etapas.id as id', 'proyectos.descripcion as proyecto', 'etapas.descripcion as etapa')
                ->where('proyectos.id_compania', '=', Auth::user()->id_compania)
                ->get();
            $compania = Companias::where('id', Auth::user()->id_compania)->first();
            $proyectos = Proyecto::where('id_compania', Auth::user()->id_compania)->get();
            $fases = Fase::where('id_compania', Auth::user()->id_compania)->get();
            $direcciones = Direccion::where('id_director', Auth::user()->id)->get();
            $ids_direccion = [];
            foreach ($direcciones as $direccion) {
                $ids_direccion [] += $direccion->id;
            }
            $gerencias = DB::table('gerencias')
                ->where(function ($query) use ($ids_direccion, $request) {
                    if ($ids_direccion != null) {
                        $query->whereIn('gerencias.id_direccion', $ids_direccion);
                    }
                })->get();
        }
        if ($rol == 7) {
            $etapas = DB::table('etapas')
                ->leftJoin('proyectos', 'etapas.id_proyecto', '=', 'proyectos.id')
                ->select('etapas.id as id', 'proyectos.descripcion as proyecto', 'etapas.descripcion as etapa')
                ->where('proyectos.id_compania', '=', Auth::user()->id_compania)
                ->get();
            $compania = Companias::where('id', Auth::user()->id_compania)->first();
            $proyectos = Proyecto::where('id_compania', Auth::user()->id_compania)->get();
            $fases = Fase::where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = Gerencia::where('id_gerente', Auth::user()->id)->get();
            $ids_direccion = [];
            foreach ($gerencias as $gerencia) {
                $ids_direccion [] += $gerencia->id_direccion;
            }
            $direcciones = DB::table('direcciones')
                ->where(function ($query) use ($ids_direccion, $request) {
                    if ($ids_direccion != null) {
                        $query->whereIn('direcciones.id', $ids_direccion);
                    }
                })->get();
        }

        return view('pages.etapas.prepare', compact('direcciones','gerencias','rol','proyectos', 'fases', 'etapas', 'compania'));
    }

    public function exportPdf(Request $request)
    {
        $proyectos = $request->input('proyectos');
        $etapas2 = $request->input('etapas');
        $todas_etapas = [];
        if($etapas2 == null) {
            $count = 0;
            $new = DB::table('etapas')
                ->leftJoin('proyectos', 'etapas.id_proyecto', '=', 'proyectos.id')
                ->select('etapas.id as id')
                ->where('proyectos.id_compania', '=', Auth::user()->id_compania)
                ->get();

            foreach ($new as $etapa) {
                $todas_etapas[$count] = $etapa->id;
                $count++;
            }
        }
        $fases = $request->input('fases');
        $direcciones = $request->input('direcciones');
        $gerencias = $request->input('gerencias');
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $time = $datetime->toTimeString();

        $etapas = DB::table('etapas')
            ->where(function($query) use ($etapas2, $todas_etapas, $request) {
                if ($etapas2 != null) {
                    $query->whereIn('etapas.id', $etapas2);
                }
                else {
                    $query->whereIn('etapas.id', $todas_etapas);
                }
            })
            ->join('companias', 'etapas.id_compania', '=', 'companias.id')
            ->where('etapas.id_compania', '=', Auth::user()->id_compania)
            ->join('proyectos', 'etapas.id_proyecto', '=', 'proyectos.id')
            ->join('gerencias', 'proyectos.id_gerencia', 'gerencias.id')
            ->where(function ($query) use ($gerencias, $request) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->join('direcciones', 'gerencias.id_direccion', '=', 'direcciones.id')
            ->where(function ($query) use ($direcciones, $request) {
                if ($direcciones != null) {
                    $query->whereIn('gerencias.id_direccion', $direcciones);
                }
            })
            ->where(function($query) use ($proyectos, $request) {
                if ($proyectos != null) {
                    $query->whereIn('etapas.id_proyecto', $proyectos);
                }
            })
            ->join('fases', 'etapas.id_fase', '=', 'fases.id')
            ->where(function($query) use ($fases, $request) {
                if ($fases != null) {
                    $query->whereIn('etapas.id_fase', $fases);
                }
            })
            ->select('etapas.*', 'companias.descripcion as compania', 'fases.descripcion as fase', 'proyectos.descripcion as proyecto','direcciones.nombre as direccion', 'gerencias.nombre as gerencia')
            ->get();

        $pdf = PDF::loadView('pdf.stages', compact('etapas', 'date', 'time'));

        return $pdf->download('etapas.pdf');
    }
}
