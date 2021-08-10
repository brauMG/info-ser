<?php


namespace App\Http\Controllers;


use App\Models\Direccion;
use App\Models\Gerencia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GerenciasController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        if(Auth::user()->id_rol ==2){
            $gerencias = DB::table('gerencias')
                ->join('direcciones', 'gerencias.id_direccion', 'direcciones.id')
                ->join('usuarios', 'gerencias.id_gerente', 'usuarios.id')
                ->where('gerencias.id_compania', Auth::user()->id_compania)
                ->select('gerencias.id as id', 'gerencias.nombre as nombre', 'usuarios.nombres as gerente', 'direcciones.nombre as direccion')
                ->get();

            return view('pages.gerencias.index',['gerencias' => $gerencias]);
        }
        else{
            return redirect('/');
        }
    }
    public function edit($id){
        $gerencia = Gerencia::where('id', $id)->get()->toArray();
        $gerentes = User::where('id_rol', 7)->where('id_compania', Auth::user()->id_compania)->get()->toArray();
        $gerenciaID = $gerencia[0]['id'];
        $gerencia = $gerencia[0];
        $direcciones = Direccion::where('id_compania', Auth::user()->id_compania)->get()->toArray();

        return view('pages.gerencias.edit', compact('gerencia', 'gerentes', 'gerenciaID', 'direcciones'));
    }

    public function update(Request $request, $id){
        $gerencia = $request->validate([
            'nombre' => ['required', 'string', 'max:500'],
            'direccion' => ['required'],
            'gerente' => ['required']
        ]);
        Gerencia::where('id', $id)->update([
            'id_compania' => Auth::user()->id_compania,
            'id_direccion' => $gerencia['direccion'],
            'id_gerente' => $gerencia['gerente'],
            'nombre' => $gerencia['nombre'],
            'fecha_creacion' => Carbon::today()->toDateString(),
            'activo' => 1
        ]);
        return redirect('/gerencias')->with('mensaje', "Gerencia editada correctamente");
    }

    public function new(){
        $gerentes = User::where('id_rol', 7)->where('id_compania', Auth::user()->id_compania)->get()->toArray();
        $direcciones = Direccion::where('id_compania', Auth::user()->id_compania)->get()->toArray();
        return view('pages.gerencias.new', compact('gerentes', 'direcciones'));
    }

    public function store(Request $request)
    {
        $gerencia = $request->validate([
            'nombre' => ['required', 'string', 'max:500'],
            'direccion' => ['required'],
            'gerente' => ['required']
        ]);
        Gerencia::create([
            'id_compania' => Auth::user()->id_compania,
            'id_direccion' => $gerencia['direccion'],
            'id_gerente' => $gerencia['gerente'],
            'nombre' => $gerencia['nombre'],
            'fecha_creacion' => Carbon::today()->toDateString(),
            'activo' => 1
        ]);
        return redirect('/gerencias')->with('mensaje', "Nueva Gerencia agregada correctamente");
    }

    public function prepare($id){
        $gerencia = Gerencia::where('id', $id)->get()->toArray();
        $gerencia = $gerencia[0];
        return view('pages.gerencias.delete', compact('gerencia'));
    }

    public function delete($id){
        $gerencia = Gerencia::find($id);
        $gerencia->delete();
        return redirect('/gerencias')->with('mensajeAlert', "Gerencia eliminada correctamente");
    }
}
