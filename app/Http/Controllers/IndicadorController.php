<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Indicador;
use App\Models\Companias;

class IndicadorController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $indicador=DB::table('indicadores')
            ->leftJoin('companias', 'indicadores.id_compania', '=', 'companias.id')
            ->select('indicadores.id','companias.descripcion as compania','indicadores.descripcion','indicadores.fecha_descripcion','indicadores.activo')
            ->where('indicadores.id_compania','=',Auth::user()->id_compania)
            ->get();
        return view('pages.indicadores.index',['indicador'=>$indicador,'compania'=>$compania]);
    }
    public function edit($id){
        $userRol = Auth::user()->id_rol;
        $indicador=Indicador::where('id', $id)->get()->toArray();
        $indicadorId = $indicador[0]['id'];
        $indicador = $indicador[0];
        $company = Companias::all();
        $indicadorCompany = $indicador['id_compania'];
        return view('pages.indicadores.edit', compact('indicador', 'indicadorId', 'company', 'indicadorCompany', 'userRol'));
    }

    public function new(){
        return view('pages.indicadores.new');
    }

    public function store(Request $request){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $indicador = $request->validate([
            'descripcion' => ['required', 'string', 'max:150'],
        ]);
        Indicador::create([
            'descripcion' => $indicador['descripcion'],
            'activo' => 1,
            'fecha_descripcion' => Carbon::today()->toDateString(),
            'id_compania' => $compania['id']
        ]);
        return redirect('/indicadores')->with('mensaje', "Nuevo indicador agregado correctamente");
    }

    public function prepare($id){
        $indicador=Indicador::where('id', $id)->get()->toArray();
        $indicador = $indicador[0];
        return view('pages.indicadores.delete', compact('indicador'));
    }
    public function delete($id){
        $indicador = Indicador::find($id);
        $indicador->delete();
        return redirect('/indicadores')->with('mensajeAlert', "Indicador eliminado correctamente");
    }

    public function update(Request $request, $Clave){
        $indicador = Indicador::where('id', $Clave)->firstOrFail();
        $indicadorNew = $request->input('indicador');

        if ($indicadorNew == $indicador->Descripcion) {
            $data = $request->validate([
                'company' => ['required']
            ]);
            Indicador::where('id', $Clave)->update([
                'activo' => 1,
                'fecha_descripcion' => Carbon::today()->toDateString(),
                'id_compania' => $data['company']
            ]);
        }
        else {
            $data = $request->validate([
                'indicador' => ['required', 'string', 'max:150'],
                'company' => ['required']
            ]);
            Indicador::where('id', $Clave)->update([
                'descripcion' => $data['indicador'],
                'activo' => 1,
                'fecha_descripcion' => Carbon::today()->toDateString(),
                'id_compania' => $data['company']
            ]);
        }
        return redirect('/indicadores')->with('mensaje', "El indicador fue editado correctamente");
    }
}
