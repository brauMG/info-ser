<?php


namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
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

class MisProyectosController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        if(Auth::user()->Clave_Rol==3){
            $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
            $proyecto=DB::table('Proyectos')
                ->leftJoin('Companias', 'Proyectos.Clave_Compania', '=', 'Companias.Clave')
                ->leftJoin('Usuarios','Usuarios.Clave','=','Proyectos.Clave_Usuario')
                ->leftJoin('Areas','Areas.Clave','=','Proyectos.Clave_Area')
                ->leftJoin('Fases','Fases.Clave','=','Proyectos.Clave_Fase')
                ->leftJoin('Enfoques','Enfoques.Clave','=','Proyectos.Clave_Enfoque')
                ->leftJoin('Trabajos','Trabajos.Clave','=','Proyectos.Clave_Trabajo')
                ->leftJoin('Indicador','Indicador.Clave','=','Proyectos.Clave_Indicador')
                ->select('Proyectos.Clave','Companias.Descripcion as Compania','Proyectos.Descripcion as Descripcion','Usuarios.Nombres as Usuario','Areas.Descripcion as Area','Fases.Descripcion as Fase','Enfoques.Descripcion AS Enfoque','Trabajos.Descripcion As Trabajo','Indicador.Descripcion As Indicador','Objectivo')
                ->where('Proyectos.Clave_Compania','=',Auth::user()->Clave_Compania)
                ->get();
            return view('Admin.MisProyectos.index',['proyecto'=>$proyecto,'compania'=>$compania]);
        }
        else{
            return redirect('/');
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
        if(Auth::user()->Clave_Rol==4){
            $company=Compania::where('Clave', Auth::user()->Clave_Compania)
                ->get();

            $area=Areas::where('Clave_Compania','=',Auth::user()->Clave_Compania)->get();
            $fase=Fase::all();
            $enfoque=Enfoque::all();
            $trabajo=Trabajo::all();
            $indicador=Indicador::all();
            return view('Admin.Proyectos.new',['company'=>$company,'areas'=>$area,'fases'=>$fase,'enfoques'=>$enfoque,'trabajos'=>$trabajo,'indicadores'=>$indicador]);
        }
        else{
            return redirect('/');
        }

    }
    public function create(Request $request){
        $proyecto = new Proyecto;
        $proyecto->Clave_Compania = Auth::user()->Clave_Compania;
        $proyecto->Descripcion = $request->descripcion;
        $proyecto->Clave_Usuario =  Auth::user()->Clave;
        $proyecto->Clave_Area = $request->area;
        $proyecto->Clave_Fase = $request->fase;
        $proyecto->Clave_Enfoque = $request->enfoque;
        $proyecto->Clave_Trabajo = $request->trabajo;
        $proyecto->Clave_Indicador = $request->indicador;
        $proyecto->Objectivo = $request->objectivo;
        $proyecto->Activo=true;
        $proyecto->save();
        return response()->json(['proyecto'=>$proyecto]);
    }
    public function delete($id){
        $proyecto = Proyecto::find($id);
        $proyecto->delete();
        return response()->json(['error'=>false]);
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
        $proyecto->Activo=true;
        $proyecto->save();
        return response()->json(['proyecto'=>$proyecto]);
    }
    public function ProyectByCompany($company){
        $projects=Proyecto::where('Clave_Compania',$company)
            ->get();
        return response()->json(['proyectos'=>$projects]);
    }
}
