<?php


namespace App\Http\Controllers;


use App\Actividad;
use App\Areas;
use App\Charts\ProjectFocusChart;
use App\Compania;
use App\Enfoque;
use App\Etapas;
use App\Fase;
use App\Indicador;
use App\Proyecto;
use App\Status;
use App\Trabajo;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GraficasController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function toProjects() {

        //PROYECTOS POR ENFOQUE
        $ProyectosEnfoque = DB::table('Proyectos')
            ->leftJoin('Enfoques', 'Proyectos.Clave_Enfoque', 'Enfoques.Clave')
            ->select('Proyectos.Descripcion as Proyecto', 'Enfoques.Descripcion as Enfoque')
            ->get();
        $peCalidad = DB::table('Proyectos')
            ->leftJoin('Enfoques', 'Proyectos.Clave_Enfoque', 'Enfoques.Clave')
            ->select('Proyectos.Descripcion as Proyecto')
            ->where('Enfoques.Clave', 1)
            ->get();
        $peGente = DB::table('Proyectos')
            ->leftJoin('Enfoques', 'Proyectos.Clave_Enfoque', 'Enfoques.Clave')
            ->select('Proyectos.Descripcion as Proyecto')
            ->where('Enfoques.Clave', 2)
            ->get();
        $peCosto = DB::table('Proyectos')
            ->leftJoin('Enfoques', 'Proyectos.Clave_Enfoque', 'Enfoques.Clave')
            ->select('Proyectos.Descripcion as Proyecto')
            ->where('Enfoques.Clave', 3)
            ->get();
        $peServicio = DB::table('Proyectos')
            ->leftJoin('Enfoques', 'Proyectos.Clave_Enfoque', 'Enfoques.Clave')
            ->select('Proyectos.Descripcion as Proyecto')
            ->where('Enfoques.Clave', 4)
            ->get();
        $peCrecimiento = DB::table('Proyectos')
            ->leftJoin('Enfoques', 'Proyectos.Clave_Enfoque', 'Enfoques.Clave')
            ->select('Proyectos.Descripcion as Proyecto')
            ->where('Enfoques.Clave', 5)
            ->get();

        $peCalidad = count($peCalidad);
        $peGente = count($peGente);
        $peCosto = count($peCosto);
        $peServicio = count($peServicio);
        $peCrecimiento = count($peCrecimiento);

        //PROYECTOS POR TRABAJO
        $ProyectosTrabajo = DB::table('Proyectos')
            ->leftJoin('Trabajos', 'Proyectos.Clave_Trabajo', 'Trabajos.Clave')
            ->select('Proyectos.Descripcion as Proyecto', 'Trabajos.Descripcion as Trabajo')
            ->get();
        $ptOperaciones = DB::table('Proyectos')
            ->leftJoin('Trabajos', 'Proyectos.Clave_Trabajo', 'Trabajos.Clave')
            ->select('Proyectos.Descripcion as Proyecto')
            ->where('Trabajos.Clave', 1)
            ->get();
        $ptAdministrativo = DB::table('Proyectos')
            ->leftJoin('Trabajos', 'Proyectos.Clave_Trabajo', 'Trabajos.Clave')
            ->select('Proyectos.Descripcion as Proyecto')
            ->where('Trabajos.Clave', 2)
            ->get();
        $ptProyectos = DB::table('Proyectos')
            ->leftJoin('Trabajos', 'Proyectos.Clave_Trabajo', 'Trabajos.Clave')
            ->select('Proyectos.Descripcion as Proyecto')
            ->where('Trabajos.Clave', 3)
            ->get();
        $ptIniciativas = DB::table('Proyectos')
            ->leftJoin('Trabajos', 'Proyectos.Clave_Trabajo', 'Trabajos.Clave')
            ->select('Proyectos.Descripcion as Proyecto')
            ->where('Trabajos.Clave', 4)
            ->get();

        $ptOperaciones = count($ptOperaciones);
        $ptAdministrativo = count($ptAdministrativo);
        $ptProyectos = count($ptProyectos);
        $ptIniciativas = count($ptIniciativas);

        //PROYECTOS POR FASE
        $ProyectosFase = DB::table('Proyectos')
            ->leftJoin('Fases', 'Proyectos.Clave_Fase', 'Fases.Clave')
            ->select('Proyectos.Descripcion as Proyecto', 'Fases.Descripcion as Fase', 'Proyectos.Clave_Fase')
            ->get();


        $fases = Fase::where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $fases = $fases->unique('Descripcion');
        $dataFases = [];

        $i = 1;
        foreach ($fases as $fase) {
            foreach ($ProyectosFase as $proyecto) {
                if ($proyecto->Clave_Fase == $fase->Clave) {
                    $dataFases [$fase->Descripcion] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $fases = array_keys($dataFases);
        $conteoFases = array_values($dataFases);

        //PROYECTOS POR INDICADOR
        $ProyectosIndicador = DB::table('Proyectos')
            ->leftJoin('Indicador', 'Proyectos.Clave_Indicador', 'Indicador.Clave')
            ->select('Proyectos.Descripcion as Proyecto', 'Indicador.Descripcion as Indicador', 'Proyectos.Clave_Indicador')
            ->get();

        $indicadores = Indicador::where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $indicadores = $indicadores->unique('Descripcion');
        $dataIndicadores = [];

        $i = 1;
        foreach ($indicadores as $indicador) {
            foreach ($ProyectosIndicador as $proyecto) {
                if ($proyecto->Clave_Indicador == $indicador->Clave) {
                    $dataIndicadores [$indicador->Descripcion] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $indicadores = array_keys($dataIndicadores);
        $conteoIndicadores = array_values($dataIndicadores);

        //PROYECTOS POR AREA
        $ProyectosArea = DB::table('Proyectos')
            ->leftJoin('Areas', 'Proyectos.Clave_Area', 'Areas.Clave')
            ->select('Proyectos.Descripcion as Proyecto', 'Areas.Descripcion as Area', 'Proyectos.Clave_Area')
            ->get();

        $areas = Areas::where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $areas = $areas->unique('Descripcion');
        $dataAreas = [];

        $i = 1;
        foreach ($areas as $area) {
            foreach ($ProyectosArea as $proyecto) {
                if ($proyecto->Clave_Area == $area->Clave) {
                    $dataAreas [$area->Descripcion] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $areas = array_keys($dataAreas);
        $conteoAreas = array_values($dataAreas);

        //PROYECTOS POR ESTADO
        $ProyectosEstado = DB::table('Proyectos')
            ->leftJoin('Status', 'Proyectos.Clave_Status', 'Status.Clave')
            ->select('Proyectos.Descripcion as Proyecto', 'Status.status as Estado', 'Proyectos.Clave_Status')
            ->get();

        $estados = Status::where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $estados = $estados->unique('status');
        $dataEstados = [];

        $i = 1;
        foreach ($estados as $estado) {
            foreach ($ProyectosEstado as $proyecto) {
                if ($proyecto->Clave_Status == $estado->Clave) {
                    $dataEstados [$estado->status] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $estados = array_keys($dataEstados);
        $conteoEstados = array_values($dataEstados);

        //PROYECTOS POR TRABAJOS POR ENFOQUE
        $ProyectosTrabajoEnfoque = DB::table('Proyectos')
            ->leftJoin('Trabajos', 'Proyectos.Clave_Trabajo', 'Trabajos.Clave')
            ->leftJoin('Enfoques', 'Proyectos.Clave_Enfoque', 'Enfoques.Clave')
            ->select('Proyectos.Descripcion as Proyecto', 'Trabajos.Descripcion as Trabajo','Enfoques.Descripcion as Enfoque', 'Proyectos.Clave_Enfoque', 'Proyectos.Clave_Trabajo')
            ->get();

        // Operaciones
        $ptfCalidadOperaciones = Proyecto::where('Clave_Enfoque', 1)->where('Clave_Trabajo', 1)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfCalidadOperaciones = count($ptfCalidadOperaciones);
        $ptfGenteOperaciones = Proyecto::where('Clave_Enfoque', 2)->where('Clave_Trabajo', 1)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfGenteOperaciones = count($ptfGenteOperaciones);
        $ptfCostoOperaciones = Proyecto::where('Clave_Enfoque', 3)->where('Clave_Trabajo', 1)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfCostoOperaciones = count($ptfCostoOperaciones);
        $ptfServicioOperaciones = Proyecto::where('Clave_Enfoque', 4)->where('Clave_Trabajo', 1)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfServicioOperaciones = count($ptfServicioOperaciones);
        $ptfCrecimientoOperaciones = Proyecto::where('Clave_Enfoque', 5)->where('Clave_Trabajo', 1)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfCrecimientoOperaciones = count($ptfCrecimientoOperaciones);

        // Administrativo
        $ptfCalidadAdministrativo = Proyecto::where('Clave_Enfoque', 1)->where('Clave_Trabajo', 2)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfCalidadAdministrativo = count($ptfCalidadAdministrativo);
        $ptfGenteAdministrativo = Proyecto::where('Clave_Enfoque', 2)->where('Clave_Trabajo', 2)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfGenteAdministrativo = count($ptfGenteAdministrativo);
        $ptfCostoAdministrativo = Proyecto::where('Clave_Enfoque', 3)->where('Clave_Trabajo', 2)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfCostoAdministrativo = count($ptfCostoAdministrativo);
        $ptfServicioAdministrativo = Proyecto::where('Clave_Enfoque', 4)->where('Clave_Trabajo', 2)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfServicioAdministrativo = count($ptfServicioAdministrativo);
        $ptfCrecimientoAdministrativo = Proyecto::where('Clave_Enfoque', 5)->where('Clave_Trabajo', 2)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfCrecimientoAdministrativo = count($ptfCrecimientoAdministrativo);

        // Proyectos
        $ptfCalidadProyectos = Proyecto::where('Clave_Enfoque', 1)->where('Clave_Trabajo', 3)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfCalidadProyectos = count($ptfCalidadProyectos);
        $ptfGenteProyectos = Proyecto::where('Clave_Enfoque', 2)->where('Clave_Trabajo', 3)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfGenteProyectos = count($ptfGenteProyectos);
        $ptfCostoProyectos = Proyecto::where('Clave_Enfoque', 3)->where('Clave_Trabajo', 3)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfCostoProyectos = count($ptfCostoProyectos);
        $ptfServicioProyectos = Proyecto::where('Clave_Enfoque', 4)->where('Clave_Trabajo', 3)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfServicioProyectos = count($ptfServicioProyectos);
        $ptfCrecimientoProyectos = Proyecto::where('Clave_Enfoque', 5)->where('Clave_Trabajo', 3)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfCrecimientoProyectos = count($ptfCrecimientoProyectos);

        // Iniciativas
        $ptfCalidadIniciativas = Proyecto::where('Clave_Enfoque', 1)->where('Clave_Trabajo', 4)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfCalidadIniciativas = count($ptfCalidadIniciativas);
        $ptfGenteIniciativas = Proyecto::where('Clave_Enfoque', 2)->where('Clave_Trabajo', 4)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfGenteIniciativas = count($ptfGenteIniciativas);
        $ptfCostoIniciativas = Proyecto::where('Clave_Enfoque', 3)->where('Clave_Trabajo', 4)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfCostoIniciativas = count($ptfCostoIniciativas);
        $ptfServicioIniciativas = Proyecto::where('Clave_Enfoque', 4)->where('Clave_Trabajo', 4)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfServicioIniciativas = count($ptfServicioIniciativas);
        $ptfCrecimientoIniciativas = Proyecto::where('Clave_Enfoque', 5)->where('Clave_Trabajo', 4)->where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $ptfCrecimientoIniciativas = count($ptfCrecimientoIniciativas);

//        0 calidad
//        1 costos
//        2 crecimiento
//        3 gente
//        4 servicios

        $dataOperaciones = [0 => $ptfCalidadOperaciones, 1 => $ptfCostoOperaciones, 2 => $ptfCrecimientoOperaciones, 3 => $ptfGenteOperaciones, 4 => $ptfServicioOperaciones];
        $dataAdministrativo = [0 => $ptfCalidadAdministrativo, 1 => $ptfCostoAdministrativo, 2 => $ptfCrecimientoAdministrativo, 3 => $ptfGenteAdministrativo, 4 => $ptfServicioAdministrativo];
        $dataProyectos = [0 => $ptfCalidadProyectos, 1 => $ptfCostoProyectos, 2 => $ptfCrecimientoProyectos, 3 => $ptfGenteProyectos, 4 => $ptfServicioProyectos];
        $dataIniciativas = [0 => $ptfCalidadIniciativas, 1 => $ptfCostoIniciativas, 2 => $ptfCrecimientoIniciativas, 3 => $ptfGenteIniciativas, 4 => $ptfServicioIniciativas];

        $total = Proyecto::where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $total = count($total);

//        dd($dataOperaciones, $dataAdministrativo, $dataProyectos, $dataIniciativas);

        $estados = array_keys($dataEstados);
        $conteoEstados = array_values($dataEstados);

        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();

        return view('Admin.Graficas.proyectos', compact(
            'ProyectosEnfoque', 'ProyectosTrabajo', 'ProyectosFase','ProyectosIndicador','ProyectosArea','ProyectosTrabajoEnfoque','ProyectosEstado', 'compania','total',
                    'peCrecimiento', 'peCalidad', 'peGente', 'peServicio', 'peCosto',
                    'ptOperaciones', 'ptAdministrativo', 'ptProyectos', 'ptIniciativas',
                    'fases', 'conteoFases',
                    'indicadores', 'conteoIndicadores',
                    'areas', 'conteoAreas',
                    'estados', 'conteoEstados',
                    'dataOperaciones', 'dataAdministrativo', 'dataProyectos', 'dataIniciativas'));
    }

    public function toActivities()
    {
        //ACTIVIDADES POR PROYECTO
        $ActividadesProyecto = DB::table('Actividades')
            ->leftJoin('Proyectos', 'Actividades.Clave_Proyecto', 'Proyectos.Clave')
            ->select('Actividades.Descripcion as Actividad', 'Proyectos.Descripcion as Proyecto', 'Actividades.Clave_Proyecto')
            ->get();

        $proyectos = Proyecto::where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $proyectos = $proyectos->unique('Descripcion');
        $dataProyectos = [];

        $i = 1;
        foreach ($proyectos as $proyecto) {
            foreach ($ActividadesProyecto as $actividad) {
                if ($actividad->Clave_Proyecto == $proyecto->Clave) {
                    $dataProyectos [$proyecto->Descripcion] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $proyectos = array_keys($dataProyectos);
        $conteoProyectos = array_values($dataProyectos);

        $total = Actividad::where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $total = count($total);

        //ACTIVIDADES POR ESTADO
        $ActividadesEstado = DB::table('Actividades')
            ->select('Actividades.Descripcion as Actividad','Actividades.Estado as Activo')
            ->get();

        $aePendiente = DB::table('Actividades')
            ->select('Actividades.Descripcion as Actividad')
            ->where('Actividades.Estado', 0)
            ->get();
        $aeAprobada = DB::table('Actividades')
            ->select('Actividades.Descripcion as Actividad')
            ->where('Actividades.Estado', 1)
            ->get();
        $aeDesaprobada = DB::table('Actividades')
            ->select('Actividades.Descripcion as Actividad')
            ->where('Actividades.Estado', 2)
            ->get();

        $aePendiente = count($aePendiente);
        $aeAprobada = count($aeAprobada);
        $aeDesaprobada = count($aeDesaprobada);

        //ACTIVIDADES POR USUARIO
        $ActividadesUsuarios = DB::table('Actividades')
            ->leftJoin('Usuarios', 'Actividades.Clave_Usuario', 'Usuarios.Clave')
            ->select('Actividades.Descripcion as Actividad', 'Usuarios.Nombres as Usuario', 'Actividades.Clave_Usuario')
            ->get();

        $usuarios = User::where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $usuarios = $usuarios->unique('Nombres');
        $dataUsuarios = [];

        $i = 1;
        foreach ($usuarios as $usuario) {
            foreach ($ActividadesUsuarios as $actividad) {
                if ($actividad->Clave_Usuario == $usuario->Clave) {
                    $dataUsuarios [$usuario->Nombres] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $usuarios = array_keys($dataUsuarios);
        $conteoUsuarios = array_values($dataUsuarios);

        //ACTIVIDADES POR ETAPA
        $ActividadesEtapas = DB::table('Actividades')
            ->leftJoin('Etapas', 'Actividades.Clave_Etapa', 'Etapas.Clave')
            ->select('Actividades.Descripcion as Actividad', 'Etapas.Descripcion as Etapa', 'Actividades.Clave_Etapa')
            ->get();

        $etapas = Etapas::where('Clave_Compania', Auth::user()->Clave_Compania)->get();
        $etapas = $etapas->unique('Descripcion');
        $dataEtapas = [];

        $i = 1;
        foreach ($etapas as $etapa) {
            foreach ($ActividadesEtapas as $actividad) {
                if ($actividad->Clave_Etapa == $etapa->Clave) {
                    $dataEtapas [$etapa->Descripcion] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $etapas = array_keys($dataEtapas);
        $conteoEtapas = array_values($dataEtapas);


        $compania=Compania::where('Clave',Auth::user()->Clave_Compania)->first();

        return view('Admin.Graficas.actividades', compact('usuarios', 'conteoUsuarios','ActividadesUsuarios','ActividadesEtapas','etapas','conteoEtapas',
            'total','compania','ActividadesProyecto','proyectos', 'conteoProyectos','ActividadesEstado','aePendiente','aeAprobada', 'aeDesaprobada'));
    }
}
