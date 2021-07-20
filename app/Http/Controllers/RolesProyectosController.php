<?php

namespace App\Http\Controllers;

//use App\Mail\AdviceActivity;
//use App\Mail\AdviceUserProject;
use Illuminate\Support\Facades\Mail;

use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Puesto;
use App\Models\Rol;
use App\Models\Companias;
use App\Models\RolProyecto;
use App\Models\Fase;
use App\Models\Proyecto;
use App\Models\RolRASIC;
use App\Models\User;
use App\Models\Areas;
use App\Models\Etapas;

class RolesProyectosController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

     public function index(){
            $compania=Companias::where('id',Auth::user()->id_compania)->first();
            $rolPROYECTO=DB::table('roles_proyectos')
                ->leftJoin('proyectos', 'roles_proyectos.id_proyecto', '=', 'proyectos.id')
                ->leftJoin('roles_rasic', 'roles_proyectos.id_rol_rasic', '=', 'roles_rasic.id')
                ->leftJoin('usuarios', 'roles_proyectos.id_usuario', '=', 'usuarios.id')
                ->leftJoin('puestos', 'usuarios.id_puesto', '=', 'puestos.id')
                ->leftJoin('fases', 'proyectos.id_fase', '=', 'fases.id')
                ->select('roles_proyectos.id as id','proyectos.descripcion as proyecto','usuarios.nombres as usuario','puestos.descripcion as puesto','roles_rasic.rol_rasic as rol_rasic', 'fases.descripcion as fase', 'roles_proyectos.activo', 'roles_proyectos.fecha_creacion')
                ->where('proyectos.id_compania','=',Auth::user()->id_compania)
                ->get();
            return view('pages.roles-proyectos.index',['rolPROYECTO' => $rolPROYECTO,'compania' => $compania]);
    }

    public function editStatus($id) {
        $rolProyectoEstado=RolProyecto::where('id', $id)->get()->toArray();
        $rolProyectoEstado = $rolProyectoEstado[0];
        $estados= [
            1,
            2
        ];
        return view('pages.roles-proyectos.editStatus', compact('estados', 'rolProyectoEstado'));
    }

    public function select(){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $companyId =Auth::user()->id_compania;
        $proyectos =  Proyecto::where('id_compania', $companyId)->get();
        return view('pages.roles-proyectos.select',compact('companyId', 'proyectos', 'compania'));
    }

    public function updateStatus(Request $request, $id){
        $status = $request->validate([
            'status' => ['required']
        ]);

        RolProyecto::where('id', $id)->update([
            'activo' => $status['status']
        ]);
        return redirect('/roles-proyectos')->with('mensaje', "El estado del usuario dentro del proyecto fue actualizado correctamente");
    }

    public function new(Request $request){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $proyectoId = $request->input('proyecto');
        $proyecto = Proyecto::where('id', $proyectoId)->first();
        $faseId = $proyecto->id_fase;
        $companyId =Auth::user()->id_compania;
        $usuarios = User::where('id_compania', $companyId)->where('id_rol', 3)->get();
        $roles = RolRASIC::all();

        return view('pages.roles-proyectos.new',compact('proyectoId','usuarios', 'roles', 'faseId', 'compania'));
    }

    public function store(Request $request){
        $faseId = $request->input('faseId');
        $proyectoId = $request->input('proyectoId');

        $data = $request->validate([
            'usuario' => ['required'],
            'rol' => ['required']
        ]);

        $UsersInProjects = RolProyecto::where('id_usuario', $data['usuario'])->where('id_proyecto', $proyectoId)->get();
        if (count($UsersInProjects) > 0) {
            return redirect('/roles-proyectos')->with('mensajeDanger', "Este usuario ya fue agregado al proyecto con anterioridad");
        }



        $i = 0;

        $actualData = RolProyecto::all()->toArray();

        foreach ($actualData as $project) {
            if ($project['id_proyecto'] == $proyectoId){
                if ($project['id_usuario'] == $data['usuario']){
                    $i = 1;
                }
            }
        }

        // DATOS DEL CORREO
        $pmo = Auth::user()->nombres;
        $project = Proyecto::where('id', $proyectoId)->get();
        $projectId = $project[0]->id;
        $project = $project[0]->descripcion;
        $user = User::where('id', $data['usuario'])->get();
        $user = $user[0]->nombres;
        $rol = RolRASIC::where('id', $data['rol'])->get();
        $rol = $rol[0]->rol_rasic;

        if ($i == 0) {
            RolProyecto::create([
                'id_proyecto' => $proyectoId,
                'id_fase' => $faseId,
                'id_rol_rasic' => $data['rol'],
                'fecha_creacion' => Carbon::now(),
                'activo' => 1,
                'id_usuario' => $data['usuario']
            ]);

            //A QUIEN DIRIGIR EL CORREO
//            $emailsAdmins = User::where('id_compania', Auth::user()->id_compania)->where('id_rol', 2)->where('envio_de_correo', true)->get();
//            $emailsAdmins = $emailsAdmins->pluck('email');
//            $emailsPMOs = User::where('id_compania', Auth::user()->id_compania)->where('id_rol', 4)->where('envio_de_correo', true)->get();
//            $emailsPMOs = $emailsPMOs->pluck('email');
//            $emailsUsers = DB::table('usuarios')
//                ->leftJoin('roles_proyectos', 'usuarios.id', 'roles_proyectos.id_usuario')
//                ->select('usuarios.email')
//                ->where('roles_proyectos.id_proyecto', $projectId)
//                ->where('usuarios.envio_de_correo', 1)
//                ->where('usuarios.id_rol', 3)
//                ->get();
//            $emailsUsers = $emailsUsers->pluck('email');

            //ENVIO DE CORREOS
//            foreach ($emailsAdmins as $email){
//                Mail::to($email)->queue(new AdviceUserProject($pmo, $user, $project, $rol));
//            }
//            foreach ($emailsPMOs as $email){
//                Mail::to($email)->queue(new AdviceUserProject($pmo, $user, $project, $rol));
//            }
//            foreach ($emailsUsers as $email){
//                Mail::to($email)->queue(new AdviceUserProject($pmo, $user, $project, $rol));
//            }

            return redirect('/roles-proyectos')->with('mensaje', "Usuario agregado correctamente al proyecto");
        }
        else {
            return redirect('/roles-proyectos')->with('mensajeDanger', "Ese usuario ya esta agregado al proyecto");
        }
    }

    public function preparePdf(Request $request) {
        $proyectos=Proyecto::where('id_compania',Auth::user()->id_compania)->get();
        $fases=Fase::where('id_compania',Auth::user()->id_compania)->get();
        $rasics=RolRASIC::all();
        $usuarios=User::where('id_compania',Auth::user()->id_compania)->get();
        $compania=Companias::where('id',Auth::user()->id_compania)->first();


        return view('pages.roles-proyectos.prepare', compact('proyectos', 'fases', 'rasics', 'usuarios', 'compania'));
    }

    public function exportPdf(Request $request)
    {
        $proyectos = $request->input('proyectos');
        $fases = $request->input('fases');
        $rasics = $request->input('rasics');
        $usuarios = $request->input('usuarios');
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $time = $datetime->toTimeString();

        $rolesUser = DB::table('roles_proyectos')
            ->join('proyectos', 'roles_proyectos.id_proyecto', '=', 'proyectos.id')
            ->where(function($query) use ($proyectos, $request) {
                if ($proyectos != null) {
                    $query->whereIn('roles_proyectos.id_proyecto', $proyectos);
                }
            })
            ->join('fases', 'roles_proyectos.id_fase', '=', 'fases.id')
            ->where(function($query) use ($fases, $request) {
                if ($fases != null) {
                    $query->whereIn('roles_proyectos.id_fase', $fases);
                }
            })
            ->join('roles_rasic', 'roles_proyectos.id_rol_rasic', '=', 'roles_rasic.id')
            ->where(function($query) use ($rasics, $request) {
                if ($rasics != null) {
                    $query->whereIn('roles_proyectos.id_rol_rasic', $rasics);
                }
            })
            ->join('usuarios', 'roles_proyectos.id_usuario', '=', 'usuarios.id')
            ->where(function($query) use ($usuarios, $request) {
                if ($usuarios != null) {
                    $query->whereIn('roles_proyectos.id_usuario', $usuarios);
                }
            })
            ->select('proyectos.descripcion as proyecto', 'fases.descripcion as fase', 'roles_rasic.rol_rasic as rol_rasic', 'usuarios.nombres as usuario')
            ->get();

        $pdf = PDF::loadView('pdf.userproject', compact('rolesUser', 'date', 'time'));

        return $pdf->download('roles_en_proyectos.pdf');
    }
}
