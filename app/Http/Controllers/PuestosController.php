<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Puesto;
use App\Compania;
class PuestosController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){

        if(Auth::user()->Clave_Rol==1 ||Auth::user()->Clave_Rol==2 ){
            $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
            $puesto=DB::table('Puestos')
            ->leftJoin('Companias', 'Puestos.Clave_Compania', '=', 'Companias.Clave')
            ->select('Puestos.Clave','Companias.Descripcion as Compania','Puestos.Puesto','Puestos.FechaCreacion','Puestos.Activo')
            ->where('Puestos.Clave_Compania','=',Auth::user()->Clave_Compania)
            ->get();
            return view('Admin.Puestos.index',['puesto'=>$puesto,'compania'=>$compania]);
        }
        else{
            return redirect('/');
        }
    }
    public function edit($id){
        $userRol = Auth::user()->Clave_Rol;
        $puesto=Puesto::where('Clave', $id)->get()->toArray();
        $company=Compania::where('Clave', Auth::user()->Clave_Compania)->get();
        $puestoId = $puesto[0]['Clave'];
        $puesto = $puesto[0];
        return view('Admin.Puestos.edit', compact('company', 'puesto', 'puestoId', 'userRol'));
    }

    public function new(){
        $company = Compania::all();
        return view('Admin.Puestos.new', compact('company'));
    }

    public function store(Request $request){
        if (Auth::user()->Clave_Rol == 1) {
            $puesto = $request->validate([
                'puesto' => ['required', 'string', 'max:150'],
                'compania' => ['required']
            ]);
            Puesto::create([
                'Puesto' => $puesto['puesto'],
                'Clave_Compania' => $puesto['compania'],
                'Activo' => 1,
                'FechaCreacion' => Carbon::today()->toDateString()
            ]);
            return redirect('/Admin/Puestos')->with('mensaje', "Nuevo puesto agregado correctamente");
        }
        else {
            $puesto = $request->validate([
                'puesto' => ['required', 'string', 'max:150']
            ]);
            Puesto::create([
                'Puesto' => $puesto['puesto'],
                'Clave_Compania' =>Auth::user()->Clave_Puesto,
                'Activo' => 1,
                'FechaCreacion' => Carbon::today()->toDateString()
            ]);
            return redirect('/Admin/Puestos')->with('mensaje', "Nuevo puesto agregado correctamente");
        }
    }

    public function prepare($id){
        $puesto=Puesto::where('Clave', $id)->get()->toArray();
        $puesto = $puesto[0];
        return view('Admin.Puestos.delete', compact('puesto'));
    }

    public function delete($id){
        $puesto = Puesto::find($id);
        $puesto->delete();
        return redirect('/Admin/Puestos')->with('mensajeAlert', "Puesto eliminado correctamente");
    }

    public function update(Request $request, $Clave){
        $puesto = $request->validate([
            'puesto' => ['required', 'string', 'max:150'],
            'compania' => ['required']
        ]);
        Puesto::where('Clave', $Clave)->update([
            'Puesto' => $puesto['puesto'],
            'Clave_Compania' => $puesto['compania'],
            'Activo' => 1,
            'FechaCreacion' => Carbon::today()->toDateString()
        ]);
        return redirect('/Admin/Puestos')->with('mensaje', "El puesto fue editado correctamente");
    }
}
