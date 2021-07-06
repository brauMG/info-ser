<?php

namespace App\Http\Controllers;

use App\Status;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Compania;
use App\Enfoque;
use Illuminate\Support\Facades\DB;

class EnfoquesController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
            $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
            $enfoque= Enfoque::all();
            return view('Admin.Enfoques.index',['enfoque'=>$enfoque,'compania'=>$compania]);
    }
    public function edit($id){
        $userRol = Auth::user()->Clave_Rol;
        $enfoque=Enfoque::where('Clave', $id)->get()->toArray();
        $enfoqueId = $enfoque[0]['Clave'];
        $enfoque = $enfoque[0];
        $company = Compania::all();
        $focusCompany = $enfoque['Clave_Compania'];
        return view('Admin.Enfoques.edit', compact('enfoque', 'enfoqueId', 'focusCompany', 'company', 'userRol'));
    }

    public function prepare($id){
        $enfoque=Enfoque::where('Clave', $id)->get()->toArray();
        $enfoque = $enfoque[0];
        return view('Admin.Enfoques.delete', compact('enfoque'));
    }

    public function new(){
        return view('Admin.Enfoques.new');
    }

    public function store(Request $request){
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $enfoque = $request->validate([
            'descripcion' => ['required', 'string', 'max:150', 'unique:Enfoques'],
        ]);
        Enfoque::create([
            'Descripcion' => $enfoque['descripcion'],
            'Activo' => 1,
            'FechaCreacion' => Carbon::today()->toDateString(),
            'Clave_Compania' => $compania['Clave']
        ]);
        return redirect('/Admin/Enfoques')->with('mensaje', "Nuevo enfoque agregado correctamente");
    }
    public function delete($id){
        $enfoque = Enfoque::find($id);
        $enfoque->delete();
        return redirect('/Admin/Enfoques')->with('mensajeAlert', "Enfoque eliminado correctamente");
    }
    public function update(Request $request, $Clave){
        $enfoque = Enfoque::where('Clave', $Clave)->firstOrFail();
        $enfoqueNew = $request->input('status');

        if ($enfoqueNew == $enfoque->Descripcion) {
            $data = $request->validate([
                'company' => ['required']
            ]);
            Status::where('Clave', $Clave)->update([
                'Activo' => 1,
                'FechaCreacion' => Carbon::today()->toDateString(),
                'Clave_Compania' => $data['company']
            ]);
        }
        else {
            $data = $request->validate([
                'enfoque' => ['required', 'string', 'max:150'],
                'company' => ['required']
            ]);
            Enfoque::where('Clave', $Clave)->update([
                'Descripcion' => $data['enfoque'],
                'Activo' => 1,
                'FechaCreacion' => Carbon::today()->toDateString(),
                'Clave_Compania' => $data['company']
            ]);
        }
        return redirect('/Admin/Enfoques')->with('mensaje', "El enfoque fue editado correctamente");
    }

}
