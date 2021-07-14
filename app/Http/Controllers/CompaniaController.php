<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Companias;
use Illuminate\Support\Facades\Redirect;

class CompaniaController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }
    public function index(){
        if(Auth::user()->id_rol==1 ){
            $company = Companias::all();
            $compania = Companias::where('id', Auth::user()->id_compania)->first();
            return view('pages.compania.index',['company'=>$company,'compania'=>$compania]);
        }
        else{
            return redirect('/');
        }
    }
    public function edit($id){
        $company = Companias::where('id', $id)->get()->toArray();
        $company = $company[0];
        return view('pages.compania.edit', compact('company'));
    }

    public function prepare($id){
        $company = Companias::where('id', $id)->get()->toArray();
        $company = $company[0];
        return view('pages.compania.delete', compact('company'));
    }

    public function new(){
        return view('pages.compania.new');
    }

    public function store(Request $request){
        $company = $request->validate([
           'descripcion' => ['required', 'string', 'max:150', 'unique:companias'],
           'dominio' => ['required', 'string', 'max:50', 'min:4']
        ]);
        Companias::create([
            'descripcion' => $company['descripcion'],
            'dominio' => $company['dominio'],
            'activo' => 1,
            'fecha_creacion' => Carbon::today()->toDateString()
        ]);
        return redirect('/companias')->with('mensaje', "Nueva compañia agregada correctamente");
    }

    public function delete($id){
        $companies = Companias::all();
        $companies = count($companies);
        if ($companies == 1) {
            return redirect('/companias')->with('mensajeDanger', "No es posible eliminar todas las compañias.");
        }
        else {
            $company = Companias::find($id);
            $company->delete();
            return redirect('/companias')->with('mensajeAlert', "Compañia eliminada correctamente");
        }
    }
    public function update(Request $request, $id){
        $company = $request->validate([
            'descripcion' => ['required', 'string', 'max:150', 'unique:companias'],
            'dominio' => ['required', 'string', 'max:50', 'min:4']
        ]);
        Companias::where('id', $id)->update([
            'descripcion' => $company['descripcion'],
            'dominio' => $company['dominio'],
            'activo' => 1,
            'fecha_creacion' => Carbon::today()->toDateString()
        ]);
        return redirect('/companias')->with('mensaje', "Compañia editada correctamente");
    }

    public function selectCompany(Request $request)
    {
        $companias = Companias::all();
        $userCompany = Auth::user()->id;
        return view('pages.compania.select', compact('companias', 'userCompany'));
    }

    public function changeCompany($id){
        $user = User::find(Auth::user()->id);
        $user->id_compania = $id;
        $user->save();
        Auth::user()->fresh();
        return back();
    }
}
