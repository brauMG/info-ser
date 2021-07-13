<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Puesto;
use App\Models\Companias;
class PuestosController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){

        if(Auth::user()->id_rol==1 ||Auth::user()->id_rol==2 ){
            $compania =Companias::where('id', Auth::user()->id_compania)->first();
            $puesto =DB::table('puestos')
            ->leftJoin('companias', 'puestos.id_companias', '=', 'companias.id')
            ->select('puestos.id','companias.descripcion as compania','puestos.descripcion','puestos.fecha_creacion','puestos.activo')
            ->where('puestos.id_companias','=', Auth::user()->id_compania)
            ->get();

            return view('pages.puestos.index',['puesto'=>$puesto,'compania'=>$compania]);
        }
        else{
            return redirect('/');
        }
    }
    public function edit($id){
        $userRol = Auth::user()->id_rol;
        $puesto=Puesto::where('id', $id)->get()->toArray();
        $company=Companias::where('id', Auth::user()->id_compania)->get();
        $puestoId = $puesto[0]['id'];
        $puesto = $puesto[0];
        return view('pages.puestos.edit', compact('company', 'puesto', 'puestoId', 'userRol'));
    }

    public function new(){
        $company = Companias::all();
        return view('pages.puestos.new', compact('company'));
    }

    public function store(Request $request){
        if (Auth::user()->id_rol == 1) {
            $puesto = $request->validate([
                'puesto' => ['required', 'string', 'max:150'],
                'compania' => ['required']
            ]);
            Puesto::create([
                'descripcion' => $puesto['puesto'],
                'id_companias' => $puesto['compania'],
                'activo' => 1,
                'fecha_creacion' => Carbon::today()->toDateString()
            ]);
            return redirect('/puesto')->with('mensaje', "Nuevo puesto agregado correctamente");
        }
        else {
            $puesto = $request->validate([
                'puesto' => ['required', 'string', 'max:150']
            ]);
            Puesto::create([
                'descripcion' => $puesto['puesto'],
                'id_companias' =>Auth::user()->id_compania,
                'activo' => 1,
                'fecha_creacion' => Carbon::today()->toDateString()
            ]);
            return redirect('/puesto')->with('mensaje', "Nuevo puesto agregado correctamente");
        }
    }

    public function prepare($id){
        $puesto=Puesto::where('id', $id)->get()->toArray();
        $puesto = $puesto[0];
        return view('pages.puestos.delete', compact('puesto'));
    }

    public function delete($id){
        $puesto = Puesto::find($id);
        $puesto->delete();
        return redirect('/puesto')->with('mensajeAlert', "Puesto eliminado correctamente");
    }

    public function update(Request $request, $id){
        $puesto = $request->validate([
            'puesto' => ['required', 'string', 'max:150'],
            'compania' => ['required']
        ]);
        Puesto::where('id', $id)->update([
            'descripcion' => $puesto['puesto'],
            'id_companias' => $puesto['compania'],
            'activo' => 1,
            'fecha_creacion' => Carbon::today()->toDateString()
        ]);
        return redirect('/puesto')->with('mensaje', "El puesto fue editado correctamente");
    }
}
