<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Companias;
use App\Models\Trabajo;
class TrabajosController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }
    public function index(){
        $trabajo=Trabajo::all();
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        return view('pages.trabajos.index',['trabajo'=>$trabajo,'compania'=>$compania]);
    }
}
