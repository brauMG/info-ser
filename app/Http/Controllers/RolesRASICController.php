<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Companias;
use App\Models\RolRASIC;

class RolesRASICController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $rolRASIC=RolRASIC::all();
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        return view('pages.roles-RASIC.index',['rolRASIC'=>$rolRASIC,'compania'=>$compania]);
    }
}
