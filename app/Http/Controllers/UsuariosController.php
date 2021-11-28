<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Excel;
use Barryvdh\DomPDF\Facade as PDF;

use App\Models\Enfoques;
use App\Models\Fase;
use App\Models\Indicador;
use App\Models\Proyecto;
use App\Models\Status;
use App\Models\Trabajo;
use App\Models\Areas;
use App\Models\Companias;
use App\Models\Rol;
use App\Models\Puesto;
use App\Models\User;

class UsuariosController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        if(Auth::user()->id_rol==1||Auth::user()->id_rol==2){
            $Usuarios=DB::table('usuarios')
                ->leftJoin('companias', 'usuarios.id_compania', '=', 'companias.id')
                ->leftJoin('areas','usuarios.id_area','=','areas.id')
                ->leftJoin('puestos','usuarios.id_puesto','=','puestos.id')
                ->leftJoin('roles','usuarios.id_rol','=','roles.id')
                ->select('usuarios.id','companias.descripcion as compania','usuarios.iniciales','usuarios.nombres','usuarios.email','areas.descripcion as area','puestos.descripcion as puesto','roles.rol as rol','usuarios.nombres','usuarios.ultima_sesion as ultima_sesion','areas.fecha_creacion','areas.activo', 'usuarios.envio_de_correo as send')
                ->where('usuarios.id_compania','=',Auth::user()->id_compania)
                ->where('usuarios.id', '!=', '1')
                ->get();
            return view('pages.usuarios.index',['usuarios'=>$Usuarios,'compania'=>$compania]);
        }else{
            return redirect('/');
        }
    }

    public function logout(){
        return view('auth.logout');
    }

    public function edit($id){
        $userRol = Auth::user()->id_rol;
        $usuario=User::where('id', $id)->get()->toArray();
        $userId = $usuario[0]['id'];
        $send = $usuario[0]['envio_de_correo'];
        $usuario = $usuario[0];
        $usuarioArea = $usuario['id_area'];
        $usuarioRol = $usuario['id_rol'];
        $usuarioPuesto = $usuario['id_puesto'];
        $area=Areas::where('id_companias',Auth::user()->id_compania)->get();
        $rol=Rol::all();
        $puesto=Puesto::where('id_companias',Auth::user()->id_compania)->get();
        $compania=Companias::where('id',Auth::user()->id_compania)->get();
        return view('pages.usuarios.edit', compact('send','userRol','usuario', 'userId', 'area', 'rol', 'puesto', 'compania', 'usuarioArea', 'usuarioRol', 'usuarioPuesto'));
    }

    public function new(){
        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        $area=Areas::where('id_companias',Auth::user()->id_compania)->get();
        $puesto=Puesto::where('id_companias',Auth::user()->id_compania)->get();
        $rol= Rol::all();
        return view('pages.usuarios.new', compact('compania', 'puesto', 'area', 'rol'));
    }

    public function store(Request $request){
        $user = new User;
        $company=$user->id_compania = Auth::user()->id_compania;

        $user = $request->validate([
            'nombres' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:50', 'unique:usuarios'],
            'area' => ['required'],
            'puesto' => ['required'],
            'rol' => ['required'],
            'password' => ['required', 'string', 'min:8', 'max:250', 'confirmed']
        ]);
        $nombres = explode(" ", $request->input('nombres'));
        $iniciales = "";

        foreach ($nombres as $l){
            $iniciales .=$l[0];
        }
        User::create([
            'id_compania' => $company,
            'iniciales' => $iniciales,
            'nombres' => $user['nombres'],
            'email' => $user['email'],
            'id_area' => $user['area'],
            'id_puesto' => $user['puesto'],
            'id_rol' => $user['rol'],
            'password' => Hash::make($user['password']),
            'ultima_sesion' => Carbon::today()->toDateString(),
            'activo' => 1,
            'fecha_creacion' => Carbon::today()->toDateString(),
            'envio_de_correo' => true

        ]);
        return redirect('/usuarios')->with('mensaje', "Nuevo usuario agregado correctamente");
    }

    public function prepare($id){
        $user=User::where('id', $id)->get()->toArray();
        $user = $user[0];
        return view('pages.usuarios.delete', compact('user'));
    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();
        return redirect('/usuarios')->with('mensajeAlert', "Usuario eliminado correctamente");
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'nombres' => 'required|unique:usuarios,nombres,' . $id,
            'email' => 'required|email',
            'area' => 'required',
            'puesto' => 'required',
            'rol' => 'required'
        ]);

        $requestData = $request->except(['_token', '_method']);

        $nombres = explode(" ", $request->input('nombres'));
        $iniciales = "";

        foreach ($nombres as $l) {
            $iniciales .= $l[0];
        }
        $requestData['iniciales'] = $iniciales;

        $user = User::findOrFail($id);

        $user->update([
            'nombres' => $requestData['nombres'],
            'email' => $requestData['email'],
            'id_area' => $requestData['area'],
            'id_rol' => $requestData['rol'],
            'id_puesto' => $requestData['puesto'],
            'iniciales' => $requestData['iniciales'],
        ]);

        return redirect('/usuarios')->with('mensaje', "El usuario fue editado correctamente");
    }

    public function editSend($id) {
        $userSend  =User::where('id', $id)->get()->toArray();
        $userSend = $userSend[0];
        $OldUser=User::where('id', $id)->get()->toArray();
        $OldUser = $OldUser[0]['envio_de_correo'];
        return view('pages.usuarios.editSend', compact('OldUser', 'userSend'));
    }

    public function updateSend(Request $request, $id) {
        $send = $request->validate([
            'send' => ['required']
        ]);
        User::where('id', $id)->update([
            'envio_de_correo' => $send['send']
        ]);
        return redirect('/usuarios')->with('mensaje', "El estado del envio de correos fue actualizado correctamente");
    }

    public function preparePdf(Request $request) {
        $areas=Areas::where('id_companias',Auth::user()->id_compania)->get();
        $puestos=Puesto::where('id_companias',Auth::user()->id_compania)->get();
        $roles=Rol::where('id', '!=', 1)->get();
        $compania=Companias::where('id',Auth::user()->id_compania)->first();

        return view('pages.usuarios.prepare', compact('areas', 'puestos', 'roles', 'compania'));
    }

    public function exportPdf(Request $request)
    {
        $areas = $request->input('areas');
        $puestos = $request->input('puestos');
        $roles = $request->input('roles');
        $datetime = Carbon::now();
        $datetime->setTimezone('GMT-7');
        $date = $datetime->toDateString();
        $time = $datetime->toTimeString();

        $usuarios = DB::table('usuarios')
            ->where('id_compania', Auth::user()->id_compania)
            ->join('areas', 'usuarios.id_area', '=', 'areas.id')
            ->where(function($query) use ($areas, $request) {
                if ($areas != null) {
                    $query->whereIn('usuarios.id_area', $areas);
                }
            })
            ->join('puestos', 'usuarios.id_puesto', '=', 'puestos.id')
            ->where(function($query) use ($puestos, $request) {
                if ($puestos != null) {
                    $query->whereIn('usuarios.id_puesto', $puestos);
                }
            })
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id')
            ->where(function($query) use ($roles, $request) {
                if ($roles != null) {
                    $query->whereIn('usuarios.id_rol', $roles);
                }
            })
            ->select('usuarios.*', 'areas.descripcion as area', 'roles.rol as rol', 'puestos.descripcion as puesto')
            ->get();


        $pdf = PDF::loadView('pdf.users', compact('usuarios', 'date', 'time'));

        return $pdf->download('usuarios.pdf');
    }
}
