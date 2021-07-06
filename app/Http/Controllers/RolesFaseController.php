<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\RolFase;
use App\Compania;
use App\Proyecto;
use App\Fase;
use App\RolRASIC;
use App\User;
class RolesFaseController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }
    public function index(){
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        //Clave	Clave_Proyecto	Clave_Fase	Clave_RolRASIC	Clave_Usuario	FechaCreacion	Activo
        $rolFASE=DB::table('RolesFase')
        ->leftJoin('Proyectos', 'RolesFase.Clave_Proyecto', '=', 'Proyectos.Clave')
        ->leftJoin('Fases', 'RolesFase.Clave_Fase', '=', 'Fases.Clave')
        ->leftJoin('RolesRASIC', 'RolesFase.Clave_RolRASIC', '=', 'RolesRASIC.Clave')
        ->leftJoin('Usuarios', 'RolesFase.Clave_Usuario', '=', 'Usuarios.Clave')
        ->select('RolesFase.Clave','Proyectos.Descripcion as Proyecto','Fases.Descripcion as Fase','RolesRASIC.RolRASIC As RolRASIC','Usuarios.Nombres as Usuario')
        ->where('Usuarios.Clave_Compania','=',Auth::user()->Clave_Compania)
        ->get();
        return view('Admin.RolesFases.index',['rolFase'=>$rolFASE,'compania'=>$compania]);
    }
    public function edit($id){
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $rolFASE=RolFase::find($id);
        $proyecto=Proyecto::where('Clave_Compania',Auth::user()->Clave_Compania)->get();
        $fase=Fase::all();
        $rolRASIC=RolRASIC::all();
        $usuario=User::where('Clave_Compania',Auth::user()->Clave_Compania);
        return view('Admin.RolesFases.edit',['rolFase'=>$rolFASE,'proyectos'=>$proyecto,'fases'=>$fase,'rolesRASIC'=>$rolRASIC,'usuarios'=>$usuario,'compania'=>$compania]);
    }

    public function new(){
        $proyecto=Proyecto::where('Clave_Compania',Auth::user()->Clave_Compania)->get();
        $fase=Fase::all();
        $rolRASIC=RolRASIC::all();
        $usuario=User::where('Clave_Compania',Auth::user()->Clave_Compania);
        return view('Admin.RolesFases.new',['proyectos'=>$proyecto,'fases'=>$fase,'rolesRASIC'=>$rolRASIC,'usuarios'=>$usuario]);
    }
    public function create(Request $request){
        $rolFASE = new RolFase;
        $rolFASE->Clave_Proyecto=$request->proyecto;
        $rolFASE->Clave_RolRASIC = $request->rolRASIC;
        $rolFASE->Clave_Fase = $request->fase;
        $rolFASE->Clave_Usuario = $request->usuario;
        $rolFASE->Activo=true;
        $rolFASE->save();
        return response()->json(['rolFase'=>$rolFASE]);
    }
    public function delete($id){
        $rolFASE = RolFase::find($id);
        $rolFASE->delete();
        return response()->json(['error'=>false]);
    }
    public function update(Request $request){
        $rolFASE = RolFase::find($request->clave);
        $rolFASE->Clave_Proyecto=$request->proyecto;
        $rolFASE->Clave_RolRASIC = $request->rolRASIC;
        $rolFASE->Clave_Fase = $request->fase;
        $rolFASE->Clave_Usuario = $request->usuario;
        $rolFASE->Activo=true;
        $rolFASE->save();
        return response()->json(['rolFASE'=>$rolFASE]);
    }
}
