<?php

namespace App\Http\Controllers;

//use App\Mail\AdviceActivity;
//use App\Mail\AdviceUserProject;
use App\Models\Direccion;
use App\Models\Gerencia;
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
         $rol = Auth::user()->id_rol;
         if (Auth::user()->id_rol == 4) {
             $gerencias = Gerencia::all();
         }
         if (Auth::user()->id_rol == 7) {
             $gerencias = Gerencia::where('id_gerente', Auth::user()->id)->get();
         }

            $compania=Companias::where('id',Auth::user()->id_compania)->first();

         if (Auth::user()->id_rol == 4) {
             $rolPROYECTO = DB::table('roles_proyectos')
                 ->leftJoin('proyectos', 'roles_proyectos.id_proyecto', '=', 'proyectos.id')
                 ->leftJoin('gerencias', 'gerencias.id', '=', 'proyectos.id_gerencia')
                 ->leftJoin('roles_rasic', 'roles_proyectos.id_rol_rasic', '=', 'roles_rasic.id')
                 ->leftJoin('usuarios', 'roles_proyectos.id_usuario', '=', 'usuarios.id')
                 ->leftJoin('puestos', 'usuarios.id_puesto', '=', 'puestos.id')
                 ->leftJoin('fases', 'proyectos.id_fase', '=', 'fases.id')
                 ->select('gerencias.nombre as gerencia', 'roles_proyectos.id as id', 'proyectos.descripcion as proyecto', 'usuarios.nombres as usuario', 'puestos.descripcion as puesto', 'roles_rasic.rol_rasic as rol_rasic', 'fases.descripcion as fase', 'roles_proyectos.activo', 'roles_proyectos.fecha_creacion')
                 ->where('proyectos.id_compania', '=', Auth::user()->id_compania)
                 ->get();
         }
         else {
             $rolPROYECTO = DB::table('roles_proyectos')
                 ->leftJoin('proyectos', 'roles_proyectos.id_proyecto', '=', 'proyectos.id')
                 ->leftJoin('gerencias', 'gerencias.id', '=', 'proyectos.id_gerencia')
                 ->leftJoin('roles_rasic', 'roles_proyectos.id_rol_rasic', '=', 'roles_rasic.id')
                 ->leftJoin('usuarios', 'roles_proyectos.id_usuario', '=', 'usuarios.id')
                 ->leftJoin('puestos', 'usuarios.id_puesto', '=', 'puestos.id')
                 ->leftJoin('fases', 'proyectos.id_fase', '=', 'fases.id')
                 ->select('gerencias.nombre as gerencia', 'roles_proyectos.id as id', 'proyectos.descripcion as proyecto', 'usuarios.nombres as usuario', 'puestos.descripcion as puesto', 'roles_rasic.rol_rasic as rol_rasic', 'fases.descripcion as fase', 'roles_proyectos.activo', 'roles_proyectos.fecha_creacion')
                 ->where('proyectos.id_compania', '=', Auth::user()->id_compania)
                 ->where('gerencias.id_gerente', Auth::user()->id)
                 ->get();
         }
            return view('pages.roles-proyectos.index',['gerencias' => $gerencias,'rol' => $rol,'rolPROYECTO' => $rolPROYECTO,'compania' => $compania]);
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
        $rol = Auth::user()->id_rol;

        if ($rol == 2 || $rol == 4 || $rol == 5) {
            $proyectos = Proyecto::where('id_compania', Auth::user()->id_compania)->get();
            $fases = Fase::where('id_compania', Auth::user()->id_compania)->get();
            $rasics = RolRASIC::all();
            $usuarios = User::where('id_compania', Auth::user()->id_compania)->whereIn('id_rol', [3,4])->get();
            $compania = Companias::where('id', Auth::user()->id_compania)->first();
            $direcciones = Direccion::where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = Gerencia::where('id_compania', Auth::user()->id_compania)->get();
        }
        if ($rol == 6) {
            $proyectos = Proyecto::where('id_compania', Auth::user()->id_compania)->get();
            $fases = Fase::where('id_compania', Auth::user()->id_compania)->get();
            $rasics = RolRASIC::all();
            $usuarios = User::where('id_compania', Auth::user()->id_compania)->whereIn('id_rol', [3,4])->get();
            $compania = Companias::where('id', Auth::user()->id_compania)->first();
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
            $proyectos = Proyecto::where('id_compania', Auth::user()->id_compania)->get();
            $fases = Fase::where('id_compania', Auth::user()->id_compania)->get();
            $rasics = RolRASIC::all();
            $usuarios = User::where('id_compania', Auth::user()->id_compania)->whereIn('id_rol', [3,4])->get();
            $compania = Companias::where('id', Auth::user()->id_compania)->first();
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

        return view('pages.roles-proyectos.prepare', compact('direcciones','gerencias','rol','proyectos', 'fases', 'rasics', 'usuarios', 'compania'));
    }

    public function exportPdf(Request $request)
    {
        $proyectos = $request->input('proyectos');
        $fases = $request->input('fases');
        $rasics = $request->input('rasics');
        $usuarios = $request->input('usuarios');
        $direcciones = $request->input('direcciones');
        $gerencias = $request->input('gerencias');
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
            ->select('proyectos.descripcion as proyecto', 'fases.descripcion as fase', 'roles_rasic.rol_rasic as rol_rasic', 'usuarios.nombres as usuario','direcciones.nombre as direccion', 'gerencias.nombre as gerencia')
            ->get();

        $pdf = PDF::loadView('pdf.userproject', compact('rolesUser', 'date', 'time'));

        return $pdf->download('roles_en_proyectos.pdf');
    }
}
