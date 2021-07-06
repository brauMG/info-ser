<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Areas;
use App\Compania;
class AreaController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        if( Auth::user()->Clave_Rol==1 ||Auth::user()->Clave_Rol==2 ){
            $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
            $area=DB::table('Areas')
            ->leftJoin('Companias', 'Areas.Clave_Compania', '=', 'Companias.Clave')
            ->where('Companias.Clave','=',Auth::user()->Clave_Compania)
            ->select('Areas.Clave','Companias.Descripcion as Compania','Areas.Descripcion','Areas.FechaCreacion','Areas.Activo')
            ->get();
            return view('Admin.Areas.index',['area'=>$area,'compania'=>$compania]);
        }
        else{
            return redirect('/');
        }
    }
    public function edit($id){
        $userRol = Auth::user()->Clave_Rol;
        $area=Areas::where('Clave', $id)->get()->toArray();
        $company=Compania::where('Clave', Auth::user()->Clave_Compania)->get();
        $areaId = $area[0]['Clave'];
        $area = $area[0];
        return view('Admin.Areas.edit', compact('area', 'company', 'areaId', 'userRol'));
    }

    public function update(Request $request, $Clave){
        $area = $request->validate([
            'descripcion' => ['required', 'string', 'max:500150'],
            'compania' => ['required']
        ]);
        Areas::where('Clave', $Clave)->update([
            'Descripcion' => $area['descripcion'],
            'Clave_Compania' => $area['compania'],
            'Activo' => 1,
            'FechaCreacion' => Carbon::today()->toDateString()
        ]);
        return redirect('/Admin/Areas')->with('mensaje', "Área editada correctamente");
    }

    public function new(){
        $company = Compania::all();
        return view('Admin.Areas.new', compact('company'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->Clave_Rol == 1) {
            $area = $request->validate([
                'descripcion' => ['required', 'string', 'max:500150'],
                'compania' => ['required']
            ]);
            Areas::create([
                'Descripcion' => $area['descripcion'],
                'Clave_Compania' => $area['compania'],
                'Activo' => 1,
                'FechaCreacion' => Carbon::today()->toDateString()
            ]);
            return redirect('/Admin/Areas')->with('mensaje', "Nueva área agregada correctamente");
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
        $area=Areas::where('Clave', $id)->get()->toArray();
        $area = $area[0];
        return view('Admin.Areas.delete', compact('area'));
    }

    public function delete($id){
        $area = Areas::find($id);
        $area->delete();
        return redirect('/Admin/Areas')->with('mensajeAlert', "Área eliminada correctamente");
    }
}
