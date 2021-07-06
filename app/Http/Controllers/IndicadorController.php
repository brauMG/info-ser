<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Compania;
use App\Indicador;
class IndicadorController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $indicador=DB::table('Indicador')
            ->leftJoin('Companias', 'Indicador.Clave_Compania', '=', 'Companias.Clave')
            ->select('Indicador.Clave','Companias.Descripcion as Compania','Indicador.Descripcion','Indicador.FechaCreacion','Indicador.Activo')
            ->where('Indicador.Clave_Compania','=',Auth::user()->Clave_Compania)
            ->get();
        return view('Admin.Indicador.index',['indicador'=>$indicador,'compania'=>$compania]);
    }
    public function edit($id){
        $userRol = Auth::user()->Clave_Rol;
        $indicador=Indicador::where('Clave', $id)->get()->toArray();
        $indicadorId = $indicador[0]['Clave'];
        $indicador = $indicador[0];
        $company = Compania::all();
        $indicadorCompany = $indicador['Clave_Compania'];
        return view('Admin.Indicador.edit', compact('indicador', 'indicadorId', 'company', 'indicadorCompany', 'userRol'));
    }

    public function new(){
        return view('Admin.Indicador.new');
    }

    public function store(Request $request){
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $indicador = $request->validate([
            'descripcion' => ['required', 'string', 'max:150'],
        ]);
        Indicador::create([
            'Descripcion' => $indicador['descripcion'],
            'Activo' => 1,
            'FechaCreacion' => Carbon::today()->toDateString(),
            'Clave_Compania' => $compania['Clave']
        ]);
        return redirect('/Admin/Indicador')->with('mensaje', "Nuevo indicador agregado correctamente");
    }

    public function prepare($id){
        $indicador=Indicador::where('Clave', $id)->get()->toArray();
        $indicador = $indicador[0];
        return view('Admin.Indicador.delete', compact('indicador'));
    }
    public function delete($id){
        $indicador = Indicador::find($id);
        $indicador->delete();
        return redirect('/Admin/Indicador')->with('mensajeAlert', "Indicador eliminado correctamente");
    }

    public function update(Request $request, $Clave){
        $indicador = Indicador::where('Clave', $Clave)->firstOrFail();
        $indicadorNew = $request->input('indicador');

        if ($indicadorNew == $indicador->Descripcion) {
            $data = $request->validate([
                'company' => ['required']
            ]);
            Indicador::where('Clave', $Clave)->update([
                'Activo' => 1,
                'FechaCreacion' => Carbon::today()->toDateString(),
                'Clave_Compania' => $data['company']
            ]);
        }
        else {
            $data = $request->validate([
                'indicador' => ['required', 'string', 'max:150'],
                'company' => ['required']
            ]);
            Indicador::where('Clave', $Clave)->update([
                'Descripcion' => $data['indicador'],
                'Activo' => 1,
                'FechaCreacion' => Carbon::today()->toDateString(),
                'Clave_Compania' => $data['company']
            ]);
        }
        return redirect('/Admin/Indicador')->with('mensaje', "El indicador fue editado correctamente");
    }
}
