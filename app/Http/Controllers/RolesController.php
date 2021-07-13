<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Companias;
use App\Models\Rol;
class RolesController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }
    public function index(){
        if(Auth::user()->id_rol==1){
            $compania=Companias::where('id',Auth::user()->id_compania)->first();
            $rol = Rol::all();
            return view('pages.roles.index',['rol'=>$rol,'compania'=>$compania]);
        }else{
            return redirect('/');
        }

    }
}
