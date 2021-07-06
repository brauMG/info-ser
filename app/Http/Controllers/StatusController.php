<?php

namespace App\Http\Controllers;

use App\Puesto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Compania;
use App\Status;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $status=DB::table('Status')
            ->leftJoin('Companias', 'Status.Clave_Compania', '=', 'Companias.Clave')
            ->select('Status.Clave','Companias.Descripcion as Compania','Status.status','Status.FechaCreacion','Status.Activo')
            ->where('Status.Clave_Compania','=',Auth::user()->Clave_Compania)
            ->get();
        return view('Admin.Status.index',['status'=>$status,'compania'=>$compania]);
    }
    public function edit($id){
        $userRol = Auth::user()->Clave_Rol;
        $status=Status::where('Clave', $id)->get()->toArray();
        $statusId = $status[0]['Clave'];
        $status = $status[0];
        $company = Compania::all();
        $statusActivo = $status['Clave_Compania'];
        $statusCompany = $status['Activo'];
        $activos = [
            0,
            1
        ];
        return view('Admin.Status.edit', compact('status', 'statusId', 'company', 'statusCompany','statusActivo', 'userRol', 'activos'));
    }

    public function new(){
        return view('Admin.Status.new');
    }
    public function store(Request $request){
        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $status = $request->validate([
            'status' => ['required', 'string', 'max:150'],
            'activo' => ['required']
        ]);
        Status::create([
            'Status' => $status['status'],
            'Activo' => $status['activo'],
            'FechaCreacion' => Carbon::today()->toDateString(),
            'Clave_Compania' => $compania['Clave']
        ]);
        return redirect('/Admin/Status')->with('mensaje', "Nuevo estado agregado correctamente");
    }

    public function prepare($id){
        $status=Status::where('Clave', $id)->get()->toArray();
        $status = $status[0];
        return view('Admin.Status.delete', compact('status'));
    }

    public function delete($id){
        $status = Status::find($id);
        $status->delete();
        return redirect('/Admin/Status')->with('mensajeAlert', "Estado eliminado correctamente");
    }

    public function update(Request $request, $Clave){
        $status = Status::where('Clave', $Clave)->firstOrFail();
        $statusNew = $request->input('status');
        $statusActive = $request->input('activo');

        if (Auth::user()->Clave_Rol == 2) {
            if ($statusNew == $status->status) {
                if ($statusActive == $status->activo) {

                } else {
                    $data = $request->validate([
                        'activo' => ['required']
                    ]);
                    Status::where('Clave', $Clave)->update([
                        'FechaCreacion' => Carbon::today()->toDateString(),
                        'Activo' => $data['activo']
                    ]);
                }
            } else if ($statusActive == $status->activo) {
                $data = $request->validate([
                    'status' => ['required', 'string', 'max:150']
                ]);
                Status::where('Clave', $Clave)->update([
                    'Status' => $data['status'],
                    'FechaCreacion' => Carbon::today()->toDateString()
                ]);
            } else {
                $data = $request->validate([
                    'status' => ['required', 'string', 'max:150'],
                    'activo' => ['required'],
                ]);
                Status::where('Clave', $Clave)->update([
                    'Status' => $data['status'],
                    'FechaCreacion' => Carbon::today()->toDateString(),
                    'Activo' => $data['activo']
                ]);
            }
            return redirect('/Admin/Status')->with('mensaje', "El estado fue editado correctamente");
        }
        if (Auth::user()->Clave_Rol == 1) {
            if ($statusNew == $status->status) {
                if ($statusActive == $status->activo) {
                    $data = $request->validate([
                        'company' => ['required']
                    ]);
                    Status::where('Clave', $Clave)->update([
                        'FechaCreacion' => Carbon::today()->toDateString(),
                        'Clave_Compania' => $data['company']
                    ]);
                } else {
                    $data = $request->validate([
                        'company' => ['required'],
                        'activo' => ['required']
                    ]);
                    Status::where('Clave', $Clave)->update([
                        'FechaCreacion' => Carbon::today()->toDateString(),
                        'Clave_Compania' => $data['company'],
                        'Activo' => $data['activo']
                    ]);
                }
            } else if ($statusActive == $status->activo) {
                $data = $request->validate([
                    'status' => ['required', 'string', 'max:150'],
                    'company' => ['required']
                ]);
                Status::where('Clave', $Clave)->update([
                    'Status' => $data['status'],
                    'FechaCreacion' => Carbon::today()->toDateString(),
                    'Clave_Compania' => $data['company']
                ]);
            } else {
                $data = $request->validate([
                    'status' => ['required', 'string', 'max:150'],
                    'activo' => ['required'],
                    'company' => ['required']
                ]);
                Status::where('Clave', $Clave)->update([
                    'Status' => $data['status'],
                    'FechaCreacion' => Carbon::today()->toDateString(),
                    'Clave_Compania' => $data['company'],
                    'Activo' => $data['activo']
                ]);
            }
            return redirect('/Admin/Status')->with('mensaje', "El estado fue editado correctamente");
        }
    }
}
