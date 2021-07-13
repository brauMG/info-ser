<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Fase;
use App\Models\Companias;

class FasesController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $fase=DB::table('fases')
            ->leftJoin('companias', 'fases.id_compania', '=', 'companias.id')
            ->select('fases.id','companias.descripcion as compania','fases.descripcion','fases.fecha_creacion','fases.activo', 'fases.orden')
            ->where('fases.id_compania','=',Auth::user()->id_compania)
            ->orderBy('orden', 'asc')
            ->get();
        return view('pages.fases.index',['fase'=>$fase,'compania'=>$compania]);
    }

    public function edit($id){
        $userRol = Auth::user()->id_rol;
        $fase=Fase::where('id', $id)->get()->toArray();
        $faseId = $fase[0]['id'];
        $fase = $fase[0];
        $company = Companias::all();
        $faseCompany = $fase['id_compania'];
        return view('pages.fases.edit', compact('fase', 'faseId', 'company', 'faseCompany', 'userRol'));
    }

    public function new(){
        return view('pages.fases.new');
    }

    public function store(Request $request){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $fase = $request->validate([
            'descripcion' => ['required', 'string', 'max:150'],
            'orden' => ['required', 'numeric']
        ]);
        Fase::create([
            'descripcion' => $fase['descripcion'],
            'activo' => 1,
            'fecha_creacion' => Carbon::today()->toDateString(),
            'id_compania' => $compania['id'],
            'orden' => $fase['orden']
        ]);
        return redirect('/fases')->with('mensaje', "Nueva fase agregada correctamente");
    }

    public function prepare($id){
        $fase=Fase::where('id', $id)->get()->toArray();
        $fase = $fase[0];
        return view('pages.fases.delete', compact('fase'));
    }

    public function delete($id){
        $fase = Fase::find($id);
        $fase->delete();
        return redirect('/fases')->with('mensajeAlert', "Fase eliminada correctamente");
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'fase' => 'required|string|max:150',
            'company' => 'required',
            'orden' => 'required|numeric'
        ]);

        $requestData = $request->except(['_token', '_method']);

        $fase = Fase::findOrFail($id);

        $fase->update([
            'descripcion' => $requestData['fase'],
            'orden' => $requestData['orden'],
            'fecha_creacion' => Carbon::today()->toDateString(),
            'activo' => 1,
            'id_compania' => $requestData['company']
        ]);
        return redirect('/fases')->with('mensaje', "La fase fue editada correctamente");
    }
}
