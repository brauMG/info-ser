<?php


namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DireccionesController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        if(Auth::user()->id_rol ==2){
            $direcciones = DB::table('direcciones')
                ->join('usuarios', 'direcciones.id_director', 'usuarios.id')
                ->where('direcciones.id_compania', Auth::user()->id_compania)
                ->select('direcciones.id as id', 'direcciones.nombre as nombre', 'usuarios.nombres as director')
                ->get();

            return view('pages.direcciones.index',['direcciones' => $direcciones]);
        }
        else{
            return redirect('/');
        }
    }
    public function edit($id){
        $direccion = Direccion::where('id', $id)->get()->toArray();
        $directores = User::where('id_rol', 6)->get()->toArray();
        $direccionID = $direccion[0]['id'];
        $direccion = $direccion[0];

        return view('pages.direcciones.edit', compact('direccion', 'directores', 'direccionID'));
    }

    public function update(Request $request, $id){
        $direccion = $request->validate([
            'nombre' => ['required', 'string', 'max:500'],
            'director' => ['required']
        ]);
        Direccion::where('id', $id)->update([
            'id_compania' => Auth::user()->id_compania,
            'id_director' => $direccion['director'],
            'nombre' => $direccion['nombre'],
            'fecha_creacion' => Carbon::today()->toDateString(),
            'activo' => 1
        ]);
        return redirect('/direcciones')->with('mensaje', "Dirección editada correctamente");
    }

    public function new(){
        $directores = User::where('id_rol', 6)->get()->toArray();
        return view('pages.direcciones.new', compact('directores'));
    }

    public function store(Request $request)
    {
        $direccion = $request->validate([
            'nombre' => ['required', 'string', 'max:500'],
            'director' => ['required']
        ]);
        Direccion::create([
            'id_compania' => Auth::user()->id_compania,
            'id_director' => $direccion['director'],
            'nombre' => $direccion['nombre'],
            'fecha_creacion' => Carbon::today()->toDateString(),
            'activo' => 1
        ]);
        return redirect('/direcciones')->with('mensaje', "Nueva Dirección agregada correctamente");
    }

    public function prepare($id){
        $direccion = Direccion::where('id', $id)->get()->toArray();
        $direccion = $direccion[0];
        return view('pages.direcciones.delete', compact('direccion'));
    }

    public function delete($id){
        $direccion = Direccion::find($id);
        $direccion->delete();
        return redirect('/direcciones')->with('mensajeAlert', "Dirección eliminada correctamente");
    }
}
