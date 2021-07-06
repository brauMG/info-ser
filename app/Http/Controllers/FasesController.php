<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Fase;
use App\Compania;
class FasesController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }


    public function index(){
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $fase=DB::table('Fases')
            ->leftJoin('Companias', 'Fases.Clave_Compania', '=', 'Companias.Clave')
            ->select('Fases.Clave','Companias.Descripcion as Compania','Fases.Descripcion','Fases.FechaCreacion','Fases.Activo', 'Fases.Orden')
            ->where('Fases.Clave_Compania','=',Auth::user()->Clave_Compania)
            ->orderBy('Orden', 'asc')
            ->get();
        return view('Admin.Fases.index',['fase'=>$fase,'compania'=>$compania]);
    }

    public function edit($id){
        $userRol = Auth::user()->Clave_Rol;
        $fase=Fase::where('Clave', $id)->get()->toArray();
        $faseId = $fase[0]['Clave'];
        $fase = $fase[0];
        $company = Compania::all();
        $faseCompany = $fase['Clave_Compania'];
        return view('Admin.Fases.edit', compact('fase', 'faseId', 'company', 'faseCompany', 'userRol'));
    }

    public function new(){
        return view('Admin.Fases.new');
    }

    public function store(Request $request){
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $fase = $request->validate([
            'descripcion' => ['required', 'string', 'max:150'],
            'orden' => ['required', 'numeric']
        ]);
        Fase::create([
            'Descripcion' => $fase['descripcion'],
            'Activo' => 1,
            'FechaCreacion' => Carbon::today()->toDateString(),
            'Clave_Compania' => $compania['Clave'],
            'Orden' => $fase['orden']
        ]);
        return redirect('/Admin/Fases')->with('mensaje', "Nueva fase agregada correctamente");
    }

    public function prepare($id){
        $fase=Fase::where('Clave', $id)->get()->toArray();
        $fase = $fase[0];
        return view('Admin.Fases.delete', compact('fase'));
    }

    public function delete($id){
        $fase = Fase::find($id);
        $fase->delete();
        return redirect('/Admin/Fases')->with('mensajeAlert', "Fase eliminada correctamente");
    }

    public function update(Request $request, $Clave){
        $fase = Fase::where('Clave', $Clave)->firstOrFail();
        $faseNew = $request->input('fase');
        $ordenNew = $request->input('orden');

        if ($faseNew == $fase->Descripcion) {
            if ($ordenNew == $fase->Orden) {
                $data = $request->validate([
                    'company' => ['required']
                ]);
                Fase::where('Clave', $Clave)->update([
                    'Activo' => 1,
                    'FechaCreacion' => Carbon::today()->toDateString(),
                    'Clave_Compania' => $data['company']
                ]);
            }
            else {
                $data = $request->validate([
                    'company' => ['required'],
                    'orden' => ['required', 'numeric']
                ]);
                Fase::where('Clave', $Clave)->update([
                    'Activo' => 1,
                    'FechaCreacion' => Carbon::today()->toDateString(),
                    'Clave_Compania' => $data['company'],
                    'Orden' => $data['orden']
                ]);
            }
        }
        elseif ($ordenNew == $fase->Orden) {
            $data = $request->validate([
                'company' => ['required'],
                'fase' => ['required', 'string', 'max:150']
            ]);
            Fase::where('Clave', $Clave)->update([
                'Activo' => 1,
                'FechaCreacion' => Carbon::today()->toDateString(),
                'Clave_Compania' => $data['company'],
                'Descripcion' => $data['fase']
            ]);
        }
        else {
            $data = $request->validate([
                'fase' => ['required', 'string', 'max:150'],
                'company' => ['required'],
                'orden' => ['required', 'numeric']
            ]);
            Fase::where('Clave', $Clave)->update([
                'Descripcion' => $data['fase'],
                'Orden' => $data['orden'],
                'Activo' => 1,
                'FechaCreacion' => Carbon::today()->toDateString(),
                'Clave_Compania' => $data['company']
            ]);
        }
        return redirect('/Admin/Fases')->with('mensaje', "La fase fue editada correctamente");
    }
}
