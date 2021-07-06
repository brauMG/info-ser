<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Compania;
use App\Rol;
class RolesController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }
    public function index(){
        if(Auth::user()->Clave_Rol==1){
            $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
            $rol=Rol::all();
            return view('Admin.Roles.index',['rol'=>$rol,'compania'=>$compania]);
        }else{
            return redirect('/');
        }

    }
    public function edit($id){
        $rol=Rol::find($id);
        return view('Admin.Roles.edit',['rol'=>$rol]);
    }

    public function new(){
        return view('Admin.Roles.new');
    }
    public function create(Request $request){
        $rol = new Rol;
        $rol->Rol = $request->rol;
        $rol->Activo=true;
        $rol->save();
        return response()->json(['rol'=>$rol]);
    }
    public function delete($id){
        $rol = Rol::find($id);
        $rol->delete();
        return response()->json(['error'=>false]);
    }
    public function update(Request $request){
        $rol = Rol::find($request->clave);
        $rol->Rol = $request->rol;
        $rol->Activo=true;
        $rol->save();
        return response()->json(['rol'=>$rol]);
    }
}
