<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Proyecto;
class EmailController extends Controller
{

        public function index(){
        	return view('Email.Usuarios');
        }
        public function send(Request $request){
        	$obj =  array(
        		'Nombre'        =>'Cristian Santiago',
                        'Reporte'       =>[]
        	);

        	Mail::to("cristian.santiago.rosas@gmail.com")->send(new Email($obj));
        	return 'Se enviaron el correo';
        }

        public function SendReporteAsignacionesEnfoque(Request $request){
        	$usuariosID=explode(',',$request->Usuarios);
        	$Proyecto=Proyecto::where('Clave',$request->Proyecto)->first();
        	$result=DB::select('CALL Get_ReportAsignacionesEnfoquesForEmail (?,?,?,?,?)',array($Proyecto->Clave,$Proyecto->Clave_Enfoque,$Proyecto->Clave_Trabajo,$request->Fase,$request->Actividad));
        	foreach($usuariosID as $id)
        	{
                        if($id!==''){
        		      $usuario=User::find($id);
        		      $obj =  array(
        			'Nombre' =>$usuario->Nombres,
        			'Reporte'=>$result
        		      );
        		      Mail::to($usuario->email)->send(new Email($obj));
                        }
        	}
        	return response()->json(['error'=>false]);
        }
}
