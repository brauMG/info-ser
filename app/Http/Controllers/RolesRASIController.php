<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Compania;
use App\RolRASIC;
class RolesRASICController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $rolRASIC=RolRASIC::all();
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        return view('Admin.RolesRASIC.index',['rolRASIC'=>$rolRASIC,'compania'=>$compania]);
    }
    public function edit($id){
        $rolRASIC=RolRASIC::find($id);
        return view('Admin.RolesRASIC.edit',['rolRASIC'=>$rolRASIC]);
    }

    public function new(){
        return view('Admin.RolesRASIC.new');
    }
    public function create(Request $request){
        $rolRASIC = new RolRASIC;
        $rolRASIC->Clave = $request->clave;
        $rolRASIC->RolRASIC = $request->rolRASIC;
        $rolRASIC->Activo=true;
        $rolRASIC->save();
        return response()->json(['rolRASIC'=>$rolRASIC]);
    }
    public function delete($id){
        $rolRASIC = RolRASIC::find($id);
        $rolRASIC->delete();
        return response()->json(['error'=>false]);
    }
    public function update(Request $request){
        $rolRASIC = RolRASIC::find($request->old_clave);
        $rolRASIC->Clave = $request->clave;
        $rolRASIC->RolRASIC = $request->rolRASIC;
        $rolRASIC->Activo=true;
        $rolRASIC->save();
        return response()->json(['rolRASIC'=>$rolRASIC]);
    }
}
