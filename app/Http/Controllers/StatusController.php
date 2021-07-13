<?php

namespace App\Http\Controllers;

use App\Models\Puesto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Companias;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $status=DB::table('estado')
            ->leftJoin('companias', 'estado.id_compania', '=', 'companias.id')
            ->select('estado.id','companias.descripcion as Compania','estado.estado','estado.fecha_creacion','estado.activo')
            ->where('estado.id_compania','=',Auth::user()->id_compania)
            ->get();
        return view('pages.estados.index',['status'=>$status,'compania'=>$compania]);
    }
//    public function edit($id){
//        $userRol = Auth::user()->id_rol;
//        $status=Status::where('id', $id)->get()->toArray();
//        $statusId = $status[0]['id'];
//        $status = $status[0];
//        $company = Companias::all();
//        $statusActivo = $status['id_compania'];
//        $statusCompany = $status['activo'];
//        $activos = [
//            0,
//            1
//        ];
//        return view('pages.estados.edit', compact('status', 'statusId', 'company', 'statusCompany','statusActivo', 'userRol', 'activos'));
//    }

    public function new(){
        return view('pages.estados.new');
    }
    public function store(Request $request){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $status = $request->validate([
            'status' => ['required', 'string', 'max:150'],
            'activo' => ['required']
        ]);
        Status::create([
            'estado' => $status['status'],
            'activo' => $status['activo'],
            'fecha_creacion' => Carbon::today()->toDateString(),
            'id_compania' => $compania['id']
        ]);
        return redirect('/estados')->with('mensaje', "Nuevo estado agregado correctamente");
    }

    public function prepare($id){
        $status=Status::where('id', $id)->get()->toArray();
        $status = $status[0];
        return view('pages.estados.delete', compact('status'));
    }

    public function delete($id){
        $status = Status::find($id);
        $status->delete();
        return redirect('/estados')->with('mensajeAlert', "Estado eliminado correctamente");
    }

//    public function update(Request $request, $id){
//        $status = Status::where('id', $id)->firstOrFail();
//        $statusNew = $request->input('status');
//        $statusActive = $request->input('activo');
//
//        if (Auth::user()->id_rol == 2) {
//            if ($statusNew == $status->status) {
//                if ($statusActive == $status->activo) {
//
//                } else {
//                    $data = $request->validate([
//                        'activo' => ['required']
//                    ]);
//                    Status::where('id', $id)->update([
//                        'fecha_creacion' => Carbon::today()->toDateString(),
//                        'activo' => $data['activo']
//                    ]);
//                }
//            } else if ($statusActive == $status->activo) {
//                $data = $request->validate([
//                    'status' => ['required', 'string', 'max:150']
//                ]);
//                Status::where('id', $id)->update([
//                    'estado' => $data['status'],
//                    'fecha_creacion' => Carbon::today()->toDateString()
//                ]);
//            } else {
//                $data = $request->validate([
//                    'status' => ['required', 'string', 'max:150'],
//                    'activo' => ['required'],
//                ]);
//                Status::where('id', $id)->update([
//                    'estado' => $data['status'],
//                    'fecha_creacion' => Carbon::today()->toDateString(),
//                    'activo' => $data['activo']
//                ]);
//            }
//            return redirect('/estados')->with('mensaje', "El estado fue editado correctamente");
//        }
//        if (Auth::user()->id_Rol == 1) {
//            if ($statusNew == $status->status) {
//                if ($statusActive == $status->activo) {
//                    $data = $request->validate([
//                        'company' => ['required']
//                    ]);
//                    Status::where('id', $id)->update([
//                        'fecha_creacion' => Carbon::today()->toDateString(),
//                        'id_compania' => $data['company']
//                    ]);
//                } else {
//                    $data = $request->validate([
//                        'company' => ['required'],
//                        'activo' => ['required']
//                    ]);
//                    Status::where('id', $id)->update([
//                        'fecha_creacion' => Carbon::today()->toDateString(),
//                        'id_compania' => $data['company'],
//                        'activo' => $data['activo']
//                    ]);
//                }
//            } else if ($statusActive == $status->activo) {
//                $data = $request->validate([
//                    'status' => ['required', 'string', 'max:150'],
//                    'company' => ['required']
//                ]);
//                Status::where('id', $id)->update([
//                    'estado' => $data['status'],
//                    'fecha_creacion' => Carbon::today()->toDateString(),
//                    'id_compania' => $data['company']
//                ]);
//            } else {
//                $data = $request->validate([
//                    'status' => ['required', 'string', 'max:150'],
//                    'activo' => ['required'],
//                    'company' => ['required']
//                ]);
//                Status::where('id', $id)->update([
//                    'estado' => $data['status'],
//                    'fecha_creacion' => Carbon::today()->toDateString(),
//                    'id_compania' => $data['company'],
//                    'activo' => $data['activo']
//                ]);
//            }
//            return redirect('/estados')->with('mensaje', "El estado fue editado correctamente");
//        }
//    }
}
