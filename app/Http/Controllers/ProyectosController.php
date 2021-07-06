<?php

namespace App\Http\Controllers;

use App\Actividad;
use App\Etapas;
use App\Mail\AdviceActivity;
use App\Mail\ChangePhase;
use App\Mail\ChangeStatus;
use App\RolRASIC;
use App\Status;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Proyecto;
use App\Compania;
use App\User;
use App\Areas;
use App\Fase;
use App\Enfoque;
use App\Trabajo;
use App\Indicador;
use Illuminate\Support\Facades\Mail;
use PDF;


class ProyectosController extends Controller
{
	//
	public function __construct(){
        $this->middleware(['auth', 'verified']);
    }
    public function index(){
        $rol = Auth::user()->Clave_Rol;
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();


        if (Auth::user()->Clave_Rol == 4) {
            $proyecto = DB::table('Proyectos')
                ->leftJoin('Companias', 'Proyectos.Clave_Compania', '=', 'Companias.Clave')
                ->leftJoin('Status', 'Status.Clave', '=', 'Proyectos.Clave_Status')
                ->leftJoin('Areas', 'Areas.Clave', '=', 'Proyectos.Clave_Area')
                ->leftJoin('Fases', 'Fases.Clave', '=', 'Proyectos.Clave_Fase')
                ->leftJoin('Enfoques', 'Enfoques.Clave', '=', 'Proyectos.Clave_Enfoque')
                ->leftJoin('Trabajos', 'Trabajos.Clave', '=', 'Proyectos.Clave_Trabajo')
                ->leftJoin('Indicador', 'Indicador.Clave', '=', 'Proyectos.Clave_Indicador')
                ->select('Proyectos.Clave','Status.Activo as Activo', 'Companias.Descripcion as Compania', 'Proyectos.Descripcion as Descripcion', 'Status.status as Status', 'Areas.Descripcion as Area', 'Fases.Descripcion as Fase', 'Enfoques.Descripcion AS Enfoque', 'Trabajos.Descripcion As Trabajo', 'Indicador.Descripcion As Indicador', 'Objectivo', 'Criterio')
                ->where('Proyectos.Clave_Compania', '=', Auth::user()->Clave_Compania)
                ->get();

            $url = url()->previous();
            $url = basename($url);
            if ($url == 'Actividades') {
                $mensaje = 'Selecciona el proyecto en el cual registraras una actividad';
                return view('Admin.Proyectos.index', ['proyecto' => $proyecto, 'compania' => $compania, 'mensaje' => $mensaje, 'rol' => $rol]);
            } else {
                return view('Admin.Proyectos.index', ['proyecto' => $proyecto, 'compania' => $compania, 'rol' => $rol]);
            }
        }

        if (Auth::user()->Clave_Rol == 3) {
            $proyecto = DB::table('RolesProyectos')
                ->leftJoin('Proyectos', 'RolesProyectos.Clave_Proyecto', '=', 'Proyectos.Clave')
                ->leftJoin('Companias', 'Proyectos.Clave_Compania', '=', 'Companias.Clave')
                ->leftJoin('Status', 'Status.Clave', '=', 'Proyectos.Clave_Status')
                ->leftJoin('Areas', 'Areas.Clave', '=', 'Proyectos.Clave_Area')
                ->leftJoin('Fases', 'Fases.Clave', '=', 'Proyectos.Clave_Fase')
                ->leftJoin('Enfoques', 'Enfoques.Clave', '=', 'Proyectos.Clave_Enfoque')
                ->leftJoin('Trabajos', 'Trabajos.Clave', '=', 'Proyectos.Clave_Trabajo')
                ->leftJoin('Indicador', 'Indicador.Clave', '=', 'Proyectos.Clave_Indicador')
                ->select('Proyectos.Clave','Status.Activo as Activo', 'Companias.Descripcion as Compania', 'Proyectos.Descripcion as Descripcion', 'Status.status as Status', 'Areas.Descripcion as Area', 'Fases.Descripcion as Fase', 'Enfoques.Descripcion AS Enfoque', 'Trabajos.Descripcion As Trabajo', 'Indicador.Descripcion As Indicador', 'Objectivo', 'Criterio')
                ->where('RolesProyectos.Clave_Usuario', '=', Auth::user()->Clave)
                ->get();

            $url = url()->previous();
            $url = basename($url);
            if ($url == 'Actividades') {
                $mensaje = 'Selecciona el proyecto en el cual registraras una actividad';
                return view('Admin.Proyectos.index', ['proyecto' => $proyecto, 'compania' => $compania, 'mensaje' => $mensaje, 'rol' => $rol]);
            } else {
                return view('Admin.Proyectos.index', ['proyecto' => $proyecto, 'compania' => $compania, 'rol' => $rol]);
            }
        }
    }

    public function edit($id){

		if(Auth::user()->Clave_Rol==4){
			$proyecto=Proyecto::find($id);
			$compania=Compania::where('Clave','=',Auth::user()->Clave_Compania)->get();
			$area=Areas::where('Clave_Compania','=',Auth::user()->Clave_Compania)->get();
			$fase=Fase::all();
			$enfoque=Enfoque::all();
			$trabajo=Trabajo::all();
			$indicador=Indicador::all();
    		return view('Admin.Proyectos.edit', ['proyecto'=>$proyecto,'companias'=>$compania,'areas'=>$area,'fases'=>$fase,'enfoques'=>$enfoque,'trabajos'=>$trabajo,'indicadores'=>$indicador]);
		}
		else{
			return redirect('/');
		}
    }

    public function new(){
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $company=Compania::where('Clave', Auth::user()->Clave_Compania)->get();
	    $areas=Areas::where('Clave_Compania','=',Auth::user()->Clave_Compania)->get();
	    $fases=Fase::where('Clave_Compania','=',Auth::user()->Clave_Compania)->get();
	    $enfoques=Enfoque::all();
	    $trabajos=Trabajo::all();
	    $indicadores=Indicador::where('Clave_Compania','=',Auth::user()->Clave_Compania)->get();
        $estados=Status::where('Clave_Compania','=',Auth::user()->Clave_Compania)->get();
        $count = 0;
        return view('Admin.Proyectos.new',['company'=>$company,'areas'=>$areas,'fases'=>$fases,'enfoques'=>$enfoques,'trabajos'=>$trabajos,'indicadores'=>$indicadores,'estados'=>$estados, 'count'=>$count,'compania'=>$compania]);
	}

    public function store(Request $request){
        $user = new User;
        $company=$user->Clave_Compania=Auth::user()->Clave_Compania;

        $project = $request->validate([
            'descripcion' => ['required', 'string', 'max:500'],
            'objetivo' => ['required', 'string', 'max:500'],
            'criterio' => ['required', 'string', 'max:500'],
            'area' => ['required'],
            'fase' => ['required'],
            'enfoque' => ['required'],
            'trabajo' => ['required'],
            'indicador' => ['required'],
            'estado' => ['required']
        ]);

        Proyecto::create([
            'Clave_Compania' => $company,
            'Descripcion' => $project['descripcion'],
            'Objectivo' => $project['objetivo'],
            'Criterio' => $project['criterio'],
            'Clave_Area' => $project['area'],
            'Clave_Fase' => $project['fase'],
            'Clave_Enfoque' => $project['enfoque'],
            'Clave_Trabajo' => $project['trabajo'],
            'Clave_Indicador' => $project['indicador'],
            'Clave_Status' => $project['estado'],
            'Activo' => 1,
            'FechaCreacion' => Carbon::today()->toDateString()

        ]);
        return redirect('/Admin/Proyectos')->with('mensaje', "Nuevo proyecto agregado correctamente");
    }
    public function delete($id){
    	$proyecto = Proyecto::find($id);
    	$proyecto->delete();
        return redirect('/Admin/Proyectos')->with('mensajeAlert', "Proyecto eliminado correctamente");
    }
    public function update(Request $request){
    	$proyecto = Proyecto::find($request->clave);
    	$proyecto->Clave_Compania = Auth::user()->Clave_Compania;
		$proyecto->Descripcion = $request->descripcion;
		$proyecto->Clave_Area = $request->area;
		$proyecto->Clave_Fase = $request->fase;
		$proyecto->Clave_Enfoque = $request->enfoque;
		$proyecto->Clave_Trabajo = $request->trabajo;
		$proyecto->Clave_Indicador = $request->indicador;
		$proyecto->Objectivo = $request->objectivo;
        $proyecto->Criterio = $request->criterio;
        $proyecto->Activo=true;
		$proyecto->save();
		return response()->json(['proyecto'=>$proyecto]);
    }
    public function ProyectByCompany($company){
    	$projects=Proyecto::where('Clave_Compania',$company)
        ->get();
        return response()->json(['proyectos'=>$projects]);
    }

    public function editStage($id) {
        $proyectoFase=Proyecto::where('Clave', $id)->get()->toArray();
        $proyectoFase = $proyectoFase[0];
        $OldFase=Fase::where('Clave', $proyectoFase['Clave_Fase'])->get()->toArray();
        $OldFase = $OldFase[0]['Clave'];
        $fases=Fase::where('Clave_Compania','=',Auth::user()->Clave_Compania)->get();
        $count = 0;
        $actividades = Actividad::where('Clave_Proyecto', $id)->where('Estado', 0)->get();
        $proyectoID = $id;
        return view('Admin.Proyectos.editStage', compact('fases', 'count', 'OldFase', 'proyectoFase', 'proyectoID'));
    }

    public function editStatus($id) {
        $proyectoEstado=Proyecto::where('Clave', $id)->get()->toArray();
        $proyectoEstado = $proyectoEstado[0];
        $OldEstado=Status::where('Clave', $proyectoEstado['Clave_Status'])->get()->toArray();
        $OldEstado = $OldEstado[0]['Clave'];
        $estados=Status::where('Clave_Compania','=',Auth::user()->Clave_Compania)->get();
        $count = 0;
        return view('Admin.Proyectos.editStatus', compact('estados', 'count', 'OldEstado', 'proyectoEstado'));
    }

    public function updateStage(Request $request, $Clave){
	    $id = $request->input('id');
        $actividades = Actividad::where('Clave_Proyecto', $id)->where('Estado', 0)->get();

        if (count($actividades) == 0) {
            $fase = $request->validate([
            'fase' => ['required']
            ]);
            Proyecto::where('Clave', $Clave)->update([
                'Clave_Fase' => $fase['fase']
            ]);

            // DATOS DEL CORREO
            $user = Auth::user()->Nombres;
            $project = Proyecto::where('Clave', $Clave)->get();
            $projectId = $project[0]->Clave;
            $project = $project[0]->Descripcion;
            $phase = Fase::where('Clave', $fase['fase'])->get();
            $phase = $phase[0]->Descripcion;

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
                Mail::to($email)->queue(new ChangePhase($user, $project, $phase));
            }
            foreach ($emailsPMOs as $email){
                Mail::to($email)->queue(new ChangePhase($user, $project, $phase));
            }
            foreach ($emailsUsers as $email){
                Mail::to($email)->queue(new ChangePhase($user, $project, $phase));
            }

            return redirect('/Admin/Proyectos')->with('mensaje', "La fase del proyecto fue actualizada correctamente");
        }
        else {
            return redirect('/Admin/Proyectos')->with('mensajeDanger', "Hay actividades pendientes por revisar. No se puede cambiar la fase del proyecto.");
        }
    }

    public function updateStatus(Request $request, $Clave){
        $status = $request->validate([
            'status' => ['required']
        ]);
        Proyecto::where('Clave', $Clave)->update([
            'Clave_Status' => $status['status']
        ]);

        // DATOS DEL CORREO
        $user = Auth::user()->Nombres;
        $project = Proyecto::where('Clave', $Clave)->get();
        $projectId = $project[0]->Clave;
        $project = $project[0]->Descripcion;
        $status = Status::where('Clave', $status['status'])->get();
        $lock = $status[0]->Activo;
        $status = $status[0]->status;

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
            Mail::to($email)->queue(new ChangeStatus($user, $lock, $project, $status));
        }
        foreach ($emailsPMOs as $email){
            Mail::to($email)->queue(new ChangeStatus($user, $lock, $project, $status));
        }
        foreach ($emailsUsers as $email){
            Mail::to($email)->queue(new ChangeStatus($user, $lock, $project, $status));
        }

        return redirect('/Admin/Proyectos')->with('mensaje', "El estado del proyecto fue actualizado correctamente");
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $role = 3;
            $i = 0;
            $usersArray = array();
            $UserArea = DB::table('Usuarios')->where('Clave_Area', '=', $request->area)->get();
            $pluckUserArea = $UserArea->pluck('Clave');
            foreach ($pluckUserArea as $user){
                $users = DB::table('Usuarios')
                    ->where('Clave','=', $pluckUserArea[$i])
                    ->where('Clave_Rol', '=', $role)
                    ->get();
                foreach ($users as $user){
                    $usersArray[$user->Clave] = $user->Nombres;
                }
                $i++;
            }
            return response()->json($usersArray);
        }
    }

    public function preparePdf(Request $request) {
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $areas=Areas::where('Clave_Compania',Auth::user()->Clave_Compania)->get();
        $enfoques=Enfoque::all();
        $trabajos=Trabajo::all();
        $indicadores=Indicador::where('Clave_Compania',Auth::user()->Clave_Compania)->get();
        $estados=Status::where('Clave_Compania',Auth::user()->Clave_Compania)->get();
        $proyectos = Proyecto::where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $fases = Fase::where('Clave_Compania', Auth::user()->Clave_Compania)->get();

        return view('Admin.Proyectos.prepare', compact('proyectos', 'fases', 'estados', 'compania', 'areas', 'enfoques', 'trabajos', 'indicadores'));
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

        $proyectos = DB::table('Proyectos')
            ->where(function($query) use ($proyectos2, $request) {
                if ($proyectos2 != null) {
                    $query->whereIn('Proyectos.Clave', $proyectos2);
                }
            })
            ->join('Fases', 'Proyectos.Clave_Fase', '=', 'Fases.Clave')
            ->where(function($query) use ($fases, $request) {
                if ($fases != null) {
                    $query->whereIn('Proyectos.Clave_Fase', $fases);
                }
            })
            ->join('Status', 'Proyectos.Clave_Status', '=', 'Status.Clave')
            ->where(function($query) use ($estados, $request) {
                if ($estados != null) {
                    $query->whereIn('Proyectos.Clave_Status', $estados);
                }
            })
            ->join('Indicador', 'Proyectos.Clave_Indicador', '=', 'Indicador.Clave')
            ->where(function($query) use ($indicadores, $request) {
                if ($indicadores != null) {
                    $query->whereIn('Proyectos.Clave_Indicador', $indicadores);
                }
            })
            ->join('Trabajos', 'Proyectos.Clave_Trabajo', '=', 'Trabajos.Clave')
            ->where(function($query) use ($trabajos, $request) {
                if ($trabajos != null) {
                    $query->whereIn('Proyectos.Clave_Trabajo', $trabajos);
                }
            })
            ->join('Enfoques', 'Proyectos.Clave_Enfoque', '=', 'Enfoques.Clave')
            ->where(function($query) use ($enfoques, $request) {
                if ($enfoques != null) {
                    $query->whereIn('Proyectos.Clave_Enfoque', $enfoques);
                }
            })
            ->join('Areas', 'Proyectos.Clave_Area', '=', 'Areas.Clave')
            ->where(function($query) use ($areas, $request) {
                if ($areas != null) {
                    $query->whereIn('Proyectos.Clave_Area', $areas);
                }
            })
            ->select('Proyectos.*', 'Fases.Descripcion as Fase', 'Status.status as Estado', 'Indicador.Descripcion as Indicador', 'Trabajos.Descripcion as Trabajo', 'Enfoques.Descripcion as Enfoque', 'Areas.Descripcion as Area')
            ->get();

        $pdf = PDF::loadView('pdf.projects', compact('proyectos', 'date', 'time'));

        return $pdf->download('proyectos.pdf');
    }
}
