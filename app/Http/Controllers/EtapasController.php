<?php


namespace App\Http\Controllers;

//use App\Mail\AdviceActivity;
//use App\Mail\AdviceStage;

use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
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
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $time = $datetime->toTimeString();
        $etapa=DB::table('etapas')
            ->leftJoin('proyectos', 'etapas.id_proyecto', '=', 'proyectos.id')
            ->leftJoin('fases', 'etapas.id_fase', '=', 'fases.id')
            ->select('etapas.id','proyectos.descripcion as proyecto','fases.descripcion as fase','etapas.descripcion','etapas.fecha_vencimiento','etapas.hora_vencimiento', 'etapas.created_at as creado')
            ->where('etapas.id_compania','=',Auth::user()->id_compania)
            ->orderBy('creado', 'asc')
            ->get();
        return view('pages.etapas.index',['etapa'=>$etapa,'compania'=>$compania, 'date'=>$date, 'time'=>$time]);
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

    public function new(){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $proyectos=Proyecto::where('id_compania',Auth::user()->id_compania)->get();
        return view('pages.etapas.new', compact('proyectos'));
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
//            Mail::to($email)->queue(new AdviceStage($user, $date, $time, $project, $stageName));
//        }
//        foreach ($emailsPMOs as $email){
//            Mail::to($email)->queue(new AdviceStage($user, $date, $time, $project, $stageName));
//        }
//        foreach ($emailsUsers as $email){
//            Mail::to($email)->queue(new AdviceStage($user, $date, $time, $project, $stageName));
//        }

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
        $etapas = DB::table('etapas')
            ->leftJoin('proyectos', 'etapas.id_proyecto', '=', 'proyectos.id')
            ->select('etapas.id as id', 'proyectos.descripcion as proyecto', 'etapas.descripcion as etapa')
            ->where('etapas.id_compania', '=', Auth::user()->id_compania)
            ->get();
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $proyectos = Proyecto::where('id_compania', Auth::user()->id_compania)->get();
        $fases = Fase::where('id_compania', Auth::user()->id_compania)->get();

        return view('pages.etapas.prepare', compact('proyectos', 'fases', 'etapas', 'compania'));
    }

    public function exportPdf(Request $request)
    {
        $proyectos = $request->input('proyectos');
        $etapas2 = $request->input('etapas');
        $fases = $request->input('fases');
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $time = $datetime->toTimeString();

        $etapas = DB::table('etapas')
            ->where(function($query) use ($etapas2, $request) {
                if ($etapas2 != null) {
                    $query->whereIn('etapas.id', $etapas2);
                }
            })
            ->join('companias', 'etapas.id_compania', '=', 'companias.id')
            ->where('etapas.id_companias', '=', Auth::user()->id_compania)
            ->join('proyectos', 'etapas.id_proyecto', '=', 'proyectos.id')
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
            ->select('etapas.*', 'companias.descripcion as compania', 'fases.descripcion as fase', 'proyectos.descripcion as proyecto')
            ->get();

        $pdf = PDF::loadView('pdf.stages', compact('etapas', 'date', 'time'));

        return $pdf->download('etapas.pdf');
    }
}
