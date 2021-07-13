<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Areas;
use App\Models\Companias;
class AreaController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        if( Auth::user()->id_rol == 1 ||Auth::user()->id_rol ==2 ){
            $compania= Companias::where('id',Auth::user()->id_compania)->first();
            $area= DB::table('areas')
            ->leftJoin('companias', 'areas.id_companias', '=', 'companias.id')
            ->where('companias.id','=',Auth::user()->id_compania)
            ->select('areas.id','companias.descripcion as compania','areas.descripcion','areas.fecha_creacion','areas.activo')
            ->get();
            return view('pages.areas.index',['areas'=>$area, 'compania'=>$compania]);
        }
        else{
            return redirect('/');
        }
    }
    public function edit($id){
        $userRol = Auth::user()->id_rol;
        $area=Areas::where('id', $id)->get()->toArray();
        $company=Companias::all();
        $areaId = $area[0]['id'];
        $area = $area[0];
        return view('pages.areas.edit', compact('area', 'company', 'areaId', 'userRol'));
    }

    public function update(Request $request, $id){
        $area = $request->validate([
            'descripcion' => ['required', 'string', 'max:500'],
            'compania' => ['required']
        ]);
        Areas::where('id', $id)->update([
            'descripcion' => $area['descripcion'],
            'id_companias' => $area['compania'],
            'activo' => 1,
            'fecha_creacion' => Carbon::today()->toDateString()
        ]);
        return redirect('/areas')->with('mensaje', "Área editada correctamente");
    }

    public function new(){
        $company = Companias::all();
        return view('pages.areas.new', compact('company'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->id_rol == 1) {
            $area = $request->validate([
                'descripcion' => ['required', 'string', 'max:500'],
                'compania' => ['required']
            ]);
            Areas::create([
                'descripcion' => $area['descripcion'],
                'id_companias' => $area['compania'],
                'activo' => 1,
                'fecha_creacion' => Carbon::today()->toDateString()
            ]);
            return redirect('/areas')->with('mensaje', "Nueva área agregada correctamente");
        }
        else {
            $area = $request->validate([
                'descripcion' => ['required', 'string', 'max:500150']
            ]);
            Areas::create([
                'Descripcion' => $area['descripcion'],
                'Clave_Compania' => Auth::user()->Clave_Compania,
                'Activo' => 1,
                'FechaCreacion' => Carbon::today()->toDateString()
            ]);
            return redirect('/Admin/Areas')->with('mensaje', "Nueva área agregada correctamente");
        }
    }

    public function prepare($id){
        $area=Areas::where('id', $id)->get()->toArray();
        $area = $area[0];
        return view('pages.areas.delete', compact('area'));
    }

    public function delete($id){
        $area = Areas::find($id);
        $area->delete();
        return redirect('/areas')->with('mensajeAlert', "Área eliminada correctamente");
    }
}
