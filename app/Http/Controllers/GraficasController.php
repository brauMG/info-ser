<?php


namespace App\Http\Controllers;


use App\Models\Actividad;
use App\Models\Areas;
use App\Models\Companias;
use App\Models\Enfoques;
use App\Models\Etapas;
use App\Models\Fase;
use App\Models\Indicador;
use App\Models\Proyecto;
use App\Models\Status;
use App\Models\trabajo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GraficasController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function toProjects() {

        //PROYECTOS POR ENFOQUE
        $proyectoenfoque = DB::table('proyectos')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto', 'enfoques.descripcion as enfoque')
            ->get();
        $peCalidad = DB::table('proyectos')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 1)
            ->get();
        $peGente = DB::table('proyectos')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 2)
            ->get();
        $peCosto = DB::table('proyectos')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 3)
            ->get();
        $peServicio = DB::table('proyectos')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 4)
            ->get();
        $peCrecimiento = DB::table('proyectos')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 5)
            ->get();

        $peCalidad = count($peCalidad);
        $peGente = count($peGente);
        $peCosto = count($peCosto);
        $peServicio = count($peServicio);
        $peCrecimiento = count($peCrecimiento);

        //PROYECTOS POR TRABAJO
        $proyectoTrabajo = DB::table('proyectos')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto', 'trabajos.descripcion as trabajo')
            ->get();
        $ptOperaciones = DB::table('proyectos')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 1)
            ->get();
        $ptAdministrativo = DB::table('proyectos')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 2)
            ->get();
        $ptProyecto = DB::table('proyectos')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 3)
            ->get();
        $ptIniciativas = DB::table('proyectos')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 4)
            ->get();

        $ptOperaciones = count($ptOperaciones);
        $ptAdministrativo = count($ptAdministrativo);
        $ptProyectos = count($ptProyecto);
        $ptIniciativas = count($ptIniciativas);

        //PROYECTOS POR FASE
        $proyectoFase = DB::table('proyectos')
            ->leftJoin('fases', 'proyectos.id_fase', 'fases.id')
            ->select('proyectos.descripcion as proyecto', 'fases.descripcion as fase', 'proyectos.id_fase')
            ->get();


        $fases = Fase::where('id_compania', Auth::user()->id_compania)->get();
        $fases = $fases->unique('descripcion');
        $datafases = [];

        $i = 1;
        foreach ($fases as $fase) {
            foreach ($proyectoFase as $proyecto) {
                if ($proyecto->id_fase == $fase->id) {
                    $datafases [$fase->descripcion] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $fases = array_keys($datafases);
        $conteofases = array_values($datafases);

        //PROYECTOS POR INDICADOR
        $proyectoIndicador = DB::table('proyectos')
            ->leftJoin('indicadores', 'proyectos.id_indicador', 'indicadores.id')
            ->select('proyectos.descripcion as proyecto', 'indicadores.descripcion as indicador', 'proyectos.id_indicador')
            ->get();

        $indicadores = Indicador::where('id_compania', Auth::user()->id_compania)->get();
        $indicadores = $indicadores->unique('descripcion');
        $dataIndicadores = [];

        $i = 1;
        foreach ($indicadores as $indicador) {
            foreach ($proyectoIndicador as $proyecto) {
                if ($proyecto->id_indicador == $indicador->id) {
                    $dataIndicadores [$indicador->descripcion] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $indicadores = array_keys($dataIndicadores);
        $conteoIndicadores = array_values($dataIndicadores);

        //PROYECTOS POR AREA
        $proyectoArea = DB::table('proyectos')
            ->leftJoin('areas', 'proyectos.id_area', 'areas.id')
            ->select('proyectos.descripcion as proyecto', 'areas.descripcion as area', 'proyectos.id_area')
            ->get();

        $areas = Areas::where('id_companias', Auth::user()->id_compania)->get();
        $areas = $areas->unique('descripcion');
        $dataAreas = [];

        $i = 1;
        foreach ($areas as $area) {
            foreach ($proyectoArea as $proyecto) {
                if ($proyecto->id_area == $area->id) {
                    $dataAreas [$area->descripcion] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $areas = array_keys($dataAreas);
        $conteoAreas = array_values($dataAreas);

        //PROYECTOS POR ESTADO
        $proyectoEstado = DB::table('proyectos')
            ->leftJoin('estado', 'proyectos.id_estado', 'estado.id')
            ->select('proyectos.descripcion as proyecto', 'estado.estado as estado', 'proyectos.id_estado')
            ->get();

        $estados = Status::where('id_compania', Auth::user()->id_compania)->get();
        $estados = $estados->unique('status');
        $dataEstados = [];

        $i = 1;
        foreach ($estados as $estado) {
            foreach ($proyectoEstado as $proyecto) {
                if ($proyecto->id_estado == $estado->id) {
                    $dataEstados [$estado->estado] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $estados = array_keys($dataEstados);
        $conteoEstados = array_values($dataEstados);

        //PROYECTOS POR TRABAJOS POR ENFOQUE
        $proyectotrabajoenfoque = DB::table('proyectos')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto', 'trabajos.descripcion as trabajo','enfoques.descripcion as enfoque', 'proyectos.id_enfoque', 'proyectos.id_trabajo')
            ->get();

        // Operaciones
        $ptfCalidadOperaciones = Proyecto::where('id_enfoque', 1)->where('id_trabajo', 1)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfCalidadOperaciones = count($ptfCalidadOperaciones);
        $ptfGenteOperaciones = Proyecto::where('id_enfoque', 2)->where('id_trabajo', 1)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfGenteOperaciones = count($ptfGenteOperaciones);
        $ptfCostoOperaciones = Proyecto::where('id_enfoque', 3)->where('id_trabajo', 1)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfCostoOperaciones = count($ptfCostoOperaciones);
        $ptfServicioOperaciones = Proyecto::where('id_enfoque', 4)->where('id_trabajo', 1)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfServicioOperaciones = count($ptfServicioOperaciones);
        $ptfCrecimientoOperaciones = Proyecto::where('id_enfoque', 5)->where('id_trabajo', 1)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfCrecimientoOperaciones = count($ptfCrecimientoOperaciones);

        // Administrativo
        $ptfCalidadAdministrativo = Proyecto::where('id_enfoque', 1)->where('id_trabajo', 2)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfCalidadAdministrativo = count($ptfCalidadAdministrativo);
        $ptfGenteAdministrativo = Proyecto::where('id_enfoque', 2)->where('id_trabajo', 2)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfGenteAdministrativo = count($ptfGenteAdministrativo);
        $ptfCostoAdministrativo = Proyecto::where('id_enfoque', 3)->where('id_trabajo', 2)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfCostoAdministrativo = count($ptfCostoAdministrativo);
        $ptfServicioAdministrativo = Proyecto::where('id_enfoque', 4)->where('id_trabajo', 2)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfServicioAdministrativo = count($ptfServicioAdministrativo);
        $ptfCrecimientoAdministrativo = Proyecto::where('id_enfoque', 5)->where('id_trabajo', 2)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfCrecimientoAdministrativo = count($ptfCrecimientoAdministrativo);

        // proyecto
        $ptfCalidadproyecto = Proyecto::where('id_enfoque', 1)->where('id_trabajo', 3)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfCalidadproyecto = count($ptfCalidadproyecto);
        $ptfGenteproyecto = Proyecto::where('id_enfoque', 2)->where('id_trabajo', 3)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfGenteproyecto = count($ptfGenteproyecto);
        $ptfCostoproyecto = Proyecto::where('id_enfoque', 3)->where('id_trabajo', 3)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfCostoproyecto = count($ptfCostoproyecto);
        $ptfServicioproyecto = Proyecto::where('id_enfoque', 4)->where('id_trabajo', 3)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfServicioproyecto = count($ptfServicioproyecto);
        $ptfCrecimientoproyecto = Proyecto::where('id_enfoque', 5)->where('id_trabajo', 3)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfCrecimientoproyecto = count($ptfCrecimientoproyecto);

        // Iniciativas
        $ptfCalidadIniciativas = Proyecto::where('id_enfoque', 1)->where('id_trabajo', 4)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfCalidadIniciativas = count($ptfCalidadIniciativas);
        $ptfGenteIniciativas = Proyecto::where('id_enfoque', 2)->where('id_trabajo', 4)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfGenteIniciativas = count($ptfGenteIniciativas);
        $ptfCostoIniciativas = Proyecto::where('id_enfoque', 3)->where('id_trabajo', 4)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfCostoIniciativas = count($ptfCostoIniciativas);
        $ptfServicioIniciativas = Proyecto::where('id_enfoque', 4)->where('id_trabajo', 4)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfServicioIniciativas = count($ptfServicioIniciativas);
        $ptfCrecimientoIniciativas = Proyecto::where('id_enfoque', 5)->where('id_trabajo', 4)->where('id_compania', Auth::user()->id_compania)->get();
        $ptfCrecimientoIniciativas = count($ptfCrecimientoIniciativas);

//        0 calidad
//        1 costos
//        2 crecimiento
//        3 gente
//        4 servicios

        $dataOperaciones = [0 => $ptfCalidadOperaciones, 1 => $ptfCostoOperaciones, 2 => $ptfCrecimientoOperaciones, 3 => $ptfGenteOperaciones, 4 => $ptfServicioOperaciones];
        $dataAdministrativo = [0 => $ptfCalidadAdministrativo, 1 => $ptfCostoAdministrativo, 2 => $ptfCrecimientoAdministrativo, 3 => $ptfGenteAdministrativo, 4 => $ptfServicioAdministrativo];
        $dataProyectos = [0 => $ptfCalidadproyecto, 1 => $ptfCostoproyecto, 2 => $ptfCrecimientoproyecto, 3 => $ptfGenteproyecto, 4 => $ptfServicioproyecto];
        $dataIniciativas = [0 => $ptfCalidadIniciativas, 1 => $ptfCostoIniciativas, 2 => $ptfCrecimientoIniciativas, 3 => $ptfGenteIniciativas, 4 => $ptfServicioIniciativas];

        $total = Proyecto::where('id_compania', Auth::user()->id_compania)->get();
        $total = count($total);

//        dd($dataOperaciones, $dataAdministrativo, $dataproyecto, $dataIniciativas);

        $estados = array_keys($dataEstados);
        $conteoEstados = array_values($dataEstados);

        $compania=Companias::where('id',Auth::user()->id_compania)->first();
        return view('pages.graficas.proyectos', compact(
            'proyectoenfoque', 'proyectoTrabajo', 'proyectoFase','proyectoIndicador','proyectoArea','proyectotrabajoenfoque','proyectoEstado', 'compania','total',
                    'peCrecimiento', 'peCalidad', 'peGente', 'peServicio', 'peCosto',
                    'ptOperaciones', 'ptAdministrativo', 'ptProyectos', 'ptIniciativas',
                    'fases', 'conteofases',
                    'indicadores', 'conteoIndicadores',
                    'areas', 'conteoAreas',
                    'estados', 'conteoEstados',
                    'dataOperaciones', 'dataAdministrativo', 'dataProyectos', 'dataIniciativas'));
    }

    public function toActivities()
    {
        //ACTIVIDADES POR PROYECTO
        $Actividadesproyecto = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->select('actividades.descricion as actividad', 'proyectos.descripcion as proyecto', 'actividades.id_proyecto')
            ->get();

        $proyectos = Proyecto::where('id_compania', Auth::user()->id_compania)->get();
        $proyectos = $proyectos->unique('descripcion');
        $dataproyecto = [];

        $i = 1;
        foreach ($proyectos as $proyecto) {
            foreach ($Actividadesproyecto as $actividad) {
                if ($actividad->id_proyecto == $proyecto->id) {
                    $dataproyecto [$proyecto->descripcion] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $proyectos = array_keys($dataproyecto);
        $conteoproyecto = array_values($dataproyecto);

        $total = Actividad::where('id_compania', Auth::user()->id_compania)->get();
        $total = count($total);

        //ACTIVIDADES POR ESTADO
        $ActividadesEstado = DB::table('actividades')
            ->select('actividades.descricion as actividad','actividades.estado as activo')
            ->get();

        $aePendiente = DB::table('actividades')
            ->select('actividades.descricion as actividad')
            ->where('actividades.estado', 0)
            ->get();
        $aeAprobada = DB::table('actividades')
            ->select('actividades.descricion as actividad')
            ->where('actividades.estado', 1)
            ->get();
        $aeDesaprobada = DB::table('actividades')
            ->select('actividades.descricion as actividad')
            ->where('actividades.estado', 2)
            ->get();

        $aePendiente = count($aePendiente);
        $aeAprobada = count($aeAprobada);
        $aeDesaprobada = count($aeDesaprobada);

        //ACTIVIDADES POR USUARIO
        $ActividadesUsuarios = DB::table('actividades')
            ->leftJoin('usuarios', 'actividades.id_usuario', 'usuarios.id')
            ->select('actividades.descricion as actividad', 'usuarios.nombres as usuario', 'actividades.id_usuario')
            ->get();

        $usuarios = User::where('id_compania', Auth::user()->id_compania)->get();
        $usuarios = $usuarios->unique('nombres');
        $dataUsuarios = [];

        $i = 1;
        foreach ($usuarios as $usuario) {
            foreach ($ActividadesUsuarios as $actividad) {
                if ($actividad->id_usuario == $usuario->id) {
                    $dataUsuarios [$usuario->nombres] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $usuarios = array_keys($dataUsuarios);
        $conteoUsuarios = array_values($dataUsuarios);

        //ACTIVIDADES POR ETAPA
        $ActividadesEtapas = DB::table('actividades')
            ->leftJoin('etapas', 'actividades.id_etapa', 'etapas.id')
            ->select('actividades.descricion as actividad', 'etapas.descripcion as etapa', 'actividades.id_etapa')
            ->get();

        $etapas = Etapas::where('id_compania', Auth::user()->id_compania)->get();
        $etapas = $etapas->unique('descripcion');
        $dataEtapas = [];

        $i = 1;
        foreach ($etapas as $etapa) {
            foreach ($ActividadesEtapas as $actividad) {
                if ($actividad->id_etapa == $etapa->id) {
                    $dataEtapas [$etapa->descripcion] = $i;
                    $i++;
                }
            }
            $i = 1;
        }

        $etapas = array_keys($dataEtapas);
        $conteoEtapas = array_values($dataEtapas);


        $compania=Companias::where('id',Auth::user()->id_compania)->first();

        return view('pages.graficas.actividades', compact('usuarios', 'conteoUsuarios','ActividadesUsuarios','ActividadesEtapas','etapas','conteoEtapas',
            'total','compania','Actividadesproyecto','proyectos', 'conteoproyecto','ActividadesEstado','aePendiente','aeAprobada', 'aeDesaprobada'));
    }
}
