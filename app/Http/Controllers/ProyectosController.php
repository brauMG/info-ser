<?php

namespace App\Http\Controllers;

use App\Models\Gerencia;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
//use App\Mail\AdviceActivity;
//use App\Mail\ChangePhase;
//use App\Mail\ChangeStatus;

use App\Models\Actividad;
use App\Models\Etapas;
use App\Models\RolRASIC;
use App\Models\Status;
use App\Models\Proyecto;
use App\Models\Companias;
use App\Models\User;
use App\Models\Areas;
use App\Models\Fase;
use App\Models\Enfoques;
use App\Models\Trabajo;
use App\Models\Indicador;

class ProyectosController extends Controller
{
	//
	public function __construct(){
        $this->middleware(['auth', 'verified']);
    }
    public function index(){
        $rol = Auth::user()->id_rol;
        $compania = Companias::where('id', Auth::user()->id_compania)->first();
        if (Auth::user()->id_rol == 4) {
            $gerencias = Gerencia::where('id_compania', Auth::user()->id_compania)->get();
        }
        if (Auth::user()->id_rol == 7) {
            $gerencias = Gerencia::where('id_gerente', Auth::user()->id)->get();
        }

        if (Auth::user()->id_rol == 4 || Auth::user()->id_rol == 7) {
            if (Auth::user()->id_rol == 4) {
                $proyecto = DB::table('proyectos')
                    ->leftJoin('companias', 'proyectos.id_compania', '=', 'companias.id')
                    ->leftJoin('gerencias', 'proyectos.id_gerencia', '=', 'gerencias.id')
                    ->leftJoin('estado', 'estado.id', '=', 'proyectos.id_estado')
                    ->leftJoin('areas', 'areas.id', '=', 'proyectos.id_area')
                    ->leftJoin('fases', 'fases.id', '=', 'proyectos.id_fase')
                    ->leftJoin('enfoques', 'enfoques.id', '=', 'proyectos.id_enfoque')
                    ->leftJoin('trabajos', 'trabajos.id', '=', 'proyectos.id_trabajo')
                    ->leftJoin('indicadores', 'indicadores.id', '=', 'proyectos.id_indicador')
                    ->select('proyectos.id', 'estado.activo as activo', 'companias.descripcion as compania', 'proyectos.descripcion as proyecto', 'estado.estado as estado', 'areas.descripcion as area', 'fases.descripcion as fase', 'enfoques.descripcion as enfoque', 'trabajos.descripcion as trabajo', 'indicadores.descripcion as indicador', 'objetivo', 'criterio', 'gerencias.nombre as gerencia')
                    ->where('proyectos.id_compania', '=', Auth::user()->id_compania)
                    ->get();
            }
            else {
                $proyecto = DB::table('proyectos')
                    ->leftJoin('companias', 'proyectos.id_compania', '=', 'companias.id')
                    ->leftJoin('gerencias', 'proyectos.id_gerencia', '=', 'gerencias.id')
                    ->leftJoin('estado', 'estado.id', '=', 'proyectos.id_estado')
                    ->leftJoin('areas', 'areas.id', '=', 'proyectos.id_area')
                    ->leftJoin('fases', 'fases.id', '=', 'proyectos.id_fase')
                    ->leftJoin('enfoques', 'enfoques.id', '=', 'proyectos.id_enfoque')
                    ->leftJoin('trabajos', 'trabajos.id', '=', 'proyectos.id_trabajo')
                    ->leftJoin('indicadores', 'indicadores.id', '=', 'proyectos.id_indicador')
                    ->select('proyectos.id', 'estado.activo as activo', 'companias.descripcion as compania', 'proyectos.descripcion as proyecto', 'estado.estado as estado', 'areas.descripcion as area', 'fases.descripcion as fase', 'enfoques.descripcion as enfoque', 'trabajos.descripcion as trabajo', 'indicadores.descripcion as indicador', 'objetivo', 'criterio', 'gerencias.nombre as gerencia')
                    ->where('proyectos.id_compania', '=', Auth::user()->id_compania)
                    ->where('gerencias.id_gerente', Auth::user()->id)
                    ->get();
            }

            $url = url()->previous();
            $url = basename($url);
            if ($url == 'actividades') {
                $mensaje = 'Selecciona el proyecto en el cual registraras una actividad';
                return view('pages.proyectos.index', ['gerencias'=> $gerencias, 'proyecto' => $proyecto, 'compania' => $compania, 'mensaje' => $mensaje, 'rol' => $rol]);
            } else {
                return view('pages.proyectos.index', ['gerencias'=> $gerencias, 'proyecto' => $proyecto, 'compania' => $compania, 'rol' => $rol]);
            }
        }

        if (Auth::user()->id_rol == 3) {
            $proyecto = DB::table('roles_proyectos')
                ->leftJoin('proyectos', 'roles_proyectos.id_proyecto', '=', 'proyectos.id')
                ->leftJoin('gerencias', 'gerencias.id', '=', 'proyectos.id_gerencia')
                ->leftJoin('companias', 'proyectos.id_compania', '=', 'companias.id')
                ->leftJoin('estado', 'estado.id', '=', 'proyectos.id_estado')
                ->leftJoin('areas', 'areas.id', '=', 'proyectos.id_area')
                ->leftJoin('fases', 'fases.id', '=', 'proyectos.id_fase')
                ->leftJoin('enfoques', 'enfoques.id', '=', 'proyectos.id_enfoque')
                ->leftJoin('trabajos', 'trabajos.id', '=', 'proyectos.id_trabajo')
                ->leftJoin('indicadores', 'indicadores.id', '=', 'proyectos.id_indicador')
                ->select('gerencias.nombre as gerencia','proyectos.id','estado.activo as activo', 'companias.descripcion as Compania', 'proyectos.descripcion as proyecto', 'estado.estado as estado', 'areas.descripcion as area', 'fases.descripcion as fase', 'enfoques.descripcion as enfoque', 'trabajos.descripcion as trabajo', 'indicadores.descripcion as indicador', 'objetivo', 'criterio', 'gerencias.nombre as gerencia')
                ->where('roles_proyectos.id_usuario', '=', Auth::user()->id)
                ->get();

            $url = url()->previous();
            $url = basename($url);
            if ($url == 'actividades') {
                $mensaje = 'Selecciona el proyecto en el cual registraras una actividad';
                return view('pages.proyectos.index', ['proyecto' => $proyecto, 'compania' => $compania, 'mensaje' => $mensaje, 'rol' => $rol]);
            } else {
                return view('pages.proyectos.index', ['proyecto' => $proyecto, 'compania' => $compania, 'rol' => $rol]);
            }
        }
    }

    public function edit($id){
		if(Auth::user()->id_rol==4){
			$proyecto= Proyecto::find($id);
			$compania=Companias::where('id', '=', Auth::user()->id_compania)->get();
			$area=Areas::where('id_companias', '=', Auth::user()->id_compania)->get();
			$fase=Fase::all();
			$enfoque=Enfoques::all();
			$trabajo=Trabajo::all();
			$indicador=Indicador::all();
    		return view('pages.proyectos.edit', ['proyecto'=>$proyecto,'companias'=>$compania,'areas'=>$area,'fases'=>$fase,'enfoques'=>$enfoque,'trabajos'=>$trabajo,'indicadores'=>$indicador]);
		}
		else{
			return redirect('/');
		}
    }

    public function new(){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $company=Companias::where('id', Auth::user()->id_compania)->get();
	    $areas=Areas::where('id_companias','=',Auth::user()->id_compania)->get();
	    $fases=Fase::where('id_compania','=',Auth::user()->id_compania)->get();
	    $enfoques=Enfoques::all();
	    $trabajos=Trabajo::all();
	    $indicadores=Indicador::where('id_compania','=',Auth::user()->id_compania)->get();
        $estados=Status::where('id_compania','=',Auth::user()->id_compania)->get();
        if (Auth::user()->id_rol == 4) {
            $gerencias = Gerencia::where('id_compania', Auth::user()->id_compania)->get();
        }
        if (Auth::user()->id_rol == 7) {
            $gerencias = Gerencia::where('id_gerente', Auth::user()->id)->get();
        }
        $count = 0;
        return view('pages.proyectos.new',['gerencias' => $gerencias,'company'=>$company,'areas'=>$areas,'fases'=>$fases,'enfoques'=>$enfoques,'trabajos'=>$trabajos,'indicadores'=>$indicadores,'estados'=>$estados, 'count'=>$count,'compania'=>$compania]);
	}

    public function store(Request $request){
        $user = new User;
        $company = $user->id_compania = Auth::user()->id_compania;

        $project = $request->validate([
            'descripcion' => ['required', 'string', 'max:500'],
            'objetivo' => ['required', 'string', 'max:500'],
            'gerencia' => ['required'],
            'criterio' => ['required', 'string', 'max:500'],
            'area' => ['required'],
            'fase' => ['required'],
            'enfoque' => ['required'],
            'trabajo' => ['required'],
            'indicador' => ['required'],
            'estado' => ['required']
        ]);

        Proyecto::create([
            'id_compania' => $company,
            'descripcion' => $project['descripcion'],
            'objetivo' => $project['objetivo'],
            'criterio' => $project['criterio'],
            'id_area' => $project['area'],
            'id_fase' => $project['fase'],
            'id_enfoque' => $project['enfoque'],
            'id_trabajo' => $project['trabajo'],
            'id_indicador' => $project['indicador'],
            'id_estado' => $project['estado'],
            'activo' => 1,
            'id_gerencia' => $project['gerencia'],
            'fecha_creacion' => Carbon::today()->toDateString()
        ]);
        return redirect('/proyectos')->with('mensaje', "Nuevo proyecto agregado correctamente");
    }
    public function delete($id){
    	$proyecto = Proyecto::find($id);
    	$proyecto->delete();
        return redirect('/proyectos')->with('mensajeAlert', "Proyecto eliminado correctamente");
    }
    public function update(Request $request){
    	$proyecto = Proyecto::find($request->id);
    	$proyecto->id_compania = Auth::user()->id_compania;
		$proyecto->descripcion = $request->descripcion;
		$proyecto->id_area = $request->area;
		$proyecto->id_fase = $request->fase;
		$proyecto->id_enfoque = $request->enfoque;
		$proyecto->id_trabajo = $request->trabajo;
		$proyecto->id_indicador = $request->indicador;
		$proyecto->objetivo = $request->objectivo;
        $proyecto->criterio = $request->criterio;
        $proyecto->activo=true;
		$proyecto->save();
		return response()->json(['proyecto'=>$proyecto]);
    }
    public function ProyectByCompany($company){
    	$projects = Proyecto::where('id_compania',$company)
        ->get();
        return response()->json(['proyectos'=>$projects]);
    }

    public function editStage($id) {
        $proyectoFase = Proyecto::where('id', $id)->get()->toArray();
        $proyectoFase = $proyectoFase[0];
        $OldFase=Fase::where('id', $proyectoFase['id_fase'])->get()->toArray();
        $OldFase = $OldFase[0]['id'];
        $fases=Fase::where('id_compania', '=', Auth::user()->id_compania)->get();
        $count = 0;
        $actividades = Actividad::where('id_proyecto', $id)->where('estado', 0)->get();
        $proyectoID = $id;
        return view('pages.proyectos.editStage', compact('fases', 'count', 'OldFase', 'proyectoFase', 'proyectoID'));
    }

    public function editStatus($id) {
        $proyectoEstado=Proyecto::where('id', $id)->get()->toArray();
        $proyectoEstado = $proyectoEstado[0];
        $OldEstado=Status::where('id', $proyectoEstado['id_estado'])->get()->toArray();
        $OldEstado = $OldEstado[0]['id'];
        $estados=Status::where('id_compania','=',Auth::user()->id_compania)->get();
        $count = 0;
        return view('pages.proyectos.editStatus', compact('estados', 'count', 'OldEstado', 'proyectoEstado'));
    }

    public function updateStage(Request $request, $id){
	    $id = $request->input('id');
        $actividades = Actividad::where('id_proyecto', $id)->where('estado', 0)->get();

        if (count($actividades) == 0) {
            $fase = $request->validate([
            'fase' => ['required']
            ]);
            Proyecto::where('id', $id)->update([
                'id_fase' => $fase['fase']
            ]);

            // DATOS DEL CORREO
//            $user = Auth::user()->nombres;
//            $project = Proyecto::where('id', $id)->get();
//            $projectId = $project[0]->id;
//            $project = $project[0]->descripcion;
//            $phase = Fase::where('id', $fase['fase'])->get();
//            $phase = $phase[0]->descripcion;

            //A QUIEN DIRIGIR EL CORREO
//            $emailsAdmins = User::where('id_compania', Auth::user()->id_compania)->where('id_rol', 2)->where('envio_de_correo', true)->get();
//            $emailsAdmins = $emailsAdmins->pluck('email');
//            $emailsPMOs = User::where('id_compania', Auth::user()->Clave_Compania)->where('id_rol', 4)->where('envio_de_correo', true)->get();
//            $emailsPMOs = $emailsPMOs->pluck('email');
//            $emailsUsers = DB::table('usuarios')
//                ->leftJoin('roles_proyectos', 'usuarios.id', 'roles_proyectos.id_usuario')
//                ->select('usuarios.email')
//                ->where('roles_proyectos.id_proyecto', $projectId)
//                ->where('usuarios.envio_de_correo', 1)
//                ->where('usuarios.id_rol', 3)
//                ->get();
//            $emailsUsers = $emailsUsers->pluck('email');
//
//            //ENVIO DE CORREOS
//            foreach ($emailsAdmins as $email){
//                Mail::to($email)->queue(new ChangePhase($user, $project, $phase));
//            }
//            foreach ($emailsPMOs as $email){
//                Mail::to($email)->queue(new ChangePhase($user, $project, $phase));
//            }
//            foreach ($emailsUsers as $email){
//                Mail::to($email)->queue(new ChangePhase($user, $project, $phase));
//            }

            return redirect('/proyectos')->with('mensaje', "La fase del proyecto fue actualizada correctamente");
        }
        else {
            return redirect('/proyectos')->with('mensajeDanger', "Hay actividades pendientes por revisar. No se puede cambiar la fase del proyecto.");
        }
    }

    public function updateStatus(Request $request, $id){
        $status = $request->validate([
            'status' => ['required']
        ]);
        Proyecto::where('id', $id)->update([
            'id_estado' => $status['status']
        ]);

        // DATOS DEL CORREO
        $user = Auth::user()->nombres;
        $project = Proyecto::where('id', $id)->get();
        $projectId = $project[0]->id;
        $project = $project[0]->descripcion;
        $status = Status::where('id', $status['status'])->get();
        $lock = $status[0]->activo;
        $status = $status[0]->estado;

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
//            Mail::to($email)->queue(new ChangeStatus($user, $lock, $project, $status));
//        }
//        foreach ($emailsPMOs as $email){
//            Mail::to($email)->queue(new ChangeStatus($user, $lock, $project, $status));
//        }
//        foreach ($emailsUsers as $email){
//            Mail::to($email)->queue(new ChangeStatus($user, $lock, $project, $status));
//        }

        return redirect('/proyectos')->with('mensaje', "El estado del proyecto fue actualizado correctamente");
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $role = 3;
            $i = 0;
            $usersArray = array();
            $UserArea = DB::table('usuarios')->where('id_area', '=', $request->area)->get();
            $pluckUserArea = $UserArea->pluck('id');
            foreach ($pluckUserArea as $user){
                $users = DB::table('usuarios')
                    ->where('id','=', $pluckUserArea[$i])
                    ->where('id_rol', '=', $role)
                    ->get();
                foreach ($users as $user){
                    $usersArray[$user->id] = $user->nombres;
                }
                $i++;
            }
            return response()->json($usersArray);
        }
    }

    public function preparePdf(Request $request) {
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $areas=Areas::where('id_companias',Auth::user()->id_compania)->get();
        $enfoques=Enfoques::all();
        $trabajos=Trabajo::all();
        $indicadores=Indicador::where('id_compania',Auth::user()->id_compania)->get();
        $estados=Status::where('id_compania',Auth::user()->id_compania)->get();
        $proyectos = Proyecto::where('id_compania', Auth::user()->id_compania)->get();
        $fases = Fase::where('id_compania', Auth::user()->id_compania)->get();

        return view('pages.proyectos.prepare', compact('proyectos', 'fases', 'estados', 'compania', 'areas', 'enfoques', 'trabajos', 'indicadores'));
    }

    public function exportPdf(Request $request)
    {
        $proyectos2 = $request->input('proyectos');
        $fases = $request->input('fases');
        $estados = $request->input('estados');
        $indicadores = $request->input('indicadores');
        $trabajos = $request->input('trabajos');
        $enfoques = $request->input('enfoques');
        $areas = $request->input('areas');
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $time = $datetime->toTimeString();

        $proyectos = DB::table('proyectos')
            ->where(function($query) use ($proyectos2, $request) {
                if ($proyectos2 != null) {
                    $query->whereIn('proyectos.id', $proyectos2);
                }
            })
            ->join('fases', 'proyectos.id_fase', '=', 'fases.id')
            ->where(function($query) use ($fases, $request) {
                if ($fases != null) {
                    $query->whereIn('proyectos.id_fase', $fases);
                }
            })
            ->join('estado', 'proyectos.id_estado', '=', 'estado.id')
            ->where(function($query) use ($estados, $request) {
                if ($estados != null) {
                    $query->whereIn('proyectos.id_estado', $estados);
                }
            })
            ->join('indicadores', 'proyectos.id_indicador', '=', 'indicadores.id')
            ->where(function($query) use ($indicadores, $request) {
                if ($indicadores != null) {
                    $query->whereIn('proyectos.id_indicador', $indicadores);
                }
            })
            ->join('trabajos', 'proyectos.id_trabajo', '=', 'trabajos.id')
            ->where(function($query) use ($trabajos, $request) {
                if ($trabajos != null) {
                    $query->whereIn('proyectos.id_trabajo', $trabajos);
                }
            })
            ->join('enfoques', 'proyectos.id_enfoque', '=', 'enfoques.id')
            ->where(function($query) use ($enfoques, $request) {
                if ($enfoques != null) {
                    $query->whereIn('proyectos.id_enfoque', $enfoques);
                }
            })
            ->join('areas', 'proyectos.id_area', '=', 'areas.id')
            ->where(function($query) use ($areas, $request) {
                if ($areas != null) {
                    $query->whereIn('proyectos.id_area', $areas);
                }
            })
            ->select('proyectos.*', 'fases.descripcion as fase', 'estado.estado as estado', 'indicadores.descripcion as indicador', 'trabajos.descripcion as trabajo', 'enfoques.descripcion as enfoque', 'areas.descripcion as area')
            ->get();

        $pdf = PDF::loadView('pdf.projects', compact('proyectos', 'date', 'time'));

        return $pdf->download('proyectos.pdf');
    }
}
