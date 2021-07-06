<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Compania;
use App\Proyecto;
use App\Enfoque;
use App\Trabajo;
class ReportesController extends Controller
{
   //
	public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function ActividadesEmpresaPorEnfoque(Request $request){
        $company=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $enfoques=Enfoque::all();
        $trabajos=Trabajo::all();
    	$reporteEnfoques =DB::select('CALL Get_ReportActividadesEmpresaPorEnfoque(?)',array($company->Clave));
    	$reporteTrabajos=DB::select('CALL Get_ReportActividadesEmpresaPorTrabajo (?)',array($company->Clave));
    	//dd($result);
		return view('Admin.Reportes.ActividadesEmpresa',['enfoques'=>$enfoques,'trabajos'=>$trabajos,'reporteEnfoques'=>$reporteEnfoques,'reporteTrabajos'=>$reporteTrabajos,'companias'=>$company,'Clave_Compania'=>$company->Clave,'compania'=>$company]);
    }
    public function proyectos(Request $request){


            $company=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
            $proyectos=Proyecto::where('Clave_Compania',$company->Clave)->get();
            $Proyecto=Proyecto::where('Clave',$request->Proyecto)->first();
            $Clave_Proyecto="";
            if($Proyecto!=null)
            {
                $Clave_Proyecto=$Proyecto->Clave;
                $result=DB::select('CALL Get_ReportAsginacionesEnfoques (?,?,?)',array($Proyecto->Clave,$Proyecto->Clave_Enfoque,$Proyecto->Clave_Trabajo));
            }
            else{
                $result=[];
            }
            $enfoques=Enfoque::all();
            $trabajos=Trabajo::all();
            return view('Admin.Reportes.ReporteAsignacionesPorEnfoque',['result'=>$result,'enfoques'=>$enfoques,'trabajos'=>$trabajos,'company'=>$company,'proyectos'=>$proyectos,'Clave_Compania'=>$request->Compania,'Clave_Proyecto'=>$Clave_Proyecto,'Clave_Enfoque'=>$request->Enfoque,'Clave_Trabajo'=>$request->Trabajo,'compania'=>$company]);

    }
    public function recursosPorRoles(Request $request){

        $company=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
		$occupation=DB::select('CALL Get_ReportOccupationResources (?)',array($company->Clave));
    	$rol=DB::select('CALL Get_ReportResourceByRol (?)',array($company->Clave));
    	return view('Admin.Reportes.ReporteRecursos',['occupation'=>$occupation,'rol'=>$rol,'company'=>$company,'Clave_Compania'=>$company->Clave,'compania'=>$company,'compania'=>$company]);
    }
    public function ActividadesEmpresaPorStatus(Request $request){

        $company=Compania::where('Clave',Auth::user()->Clave_Compania)->first();
        $activity =DB::select('CALL Get_ReportActivityByStatus(?)',array($company->Clave));
        return view('Admin.Reportes.ReporteActividadesPorEstatus',['activity'=>$activity,'company'=>$company,'Clave_Compania'=>$company->Clave,'compania'=>$company]);
    }
}
