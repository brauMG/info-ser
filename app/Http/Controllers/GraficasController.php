<?php


namespace App\Http\Controllers;


use App\Models\Actividad;
use App\Models\Areas;
use App\Models\Companias;
use App\Models\Direccion;
use App\Models\Enfoques;
use App\Models\Etapas;
use App\Models\Fase;
use App\Models\Gerencia;
use App\Models\Indicador;
use App\Models\Proyecto;
use App\Models\Status;
use App\Models\trabajo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Illuminate\Http\Request;
use PhpParser\Node\Scalar\MagicConst\Dir;
use const http\Client\Curl\AUTH_ANY;

class GraficasController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function toProjects() {
        $dir = null;
        $rol = Auth::user()->id_rol;
        if (Auth::user()->id_rol == 4 || Auth::user()->id_rol == 5 || Auth::user()->id_rol == 2) {
            $direcciones = Direccion::where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = Gerencia::where('id_compania', Auth::user()->id_compania)->get();
        }
        if (Auth::user()->id_rol == 6) {
            $direcciones = Direccion::where('id_director', Auth::user()->id)->where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = DB::table('gerencias')
                ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
                ->select('gerencias.*')
                ->where('direcciones.id_director', Auth::user()->id)
                ->where('direcciones.id_compania', Auth::user()->id_compania)
                ->get();
        }
        if (Auth::user()->id_rol == 7) {
            $direcciones = null;
            $gerencias = Gerencia::where('id_gerente', Auth::user()->id)->where('id_compania', Auth::user()->id_compania)->get();
        }

            //PROYECTOS POR ENFOQUE
        $proyectoenfoque = DB::table('proyectos')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto', 'enfoques.descripcion as enfoque')
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $peCalidad = DB::table('proyectos')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 1)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $peGente = DB::table('proyectos')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 2)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $peCosto = DB::table('proyectos')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 3)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $peServicio = DB::table('proyectos')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 4)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $peCrecimiento = DB::table('proyectos')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 5)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
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
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptOperaciones = DB::table('proyectos')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 1)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptAdministrativo = DB::table('proyectos')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 2)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptProyecto = DB::table('proyectos')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 3)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptIniciativas = DB::table('proyectos')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 4)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();

        $ptOperaciones = count($ptOperaciones);
        $ptAdministrativo = count($ptAdministrativo);
        $ptProyectos = count($ptProyecto);
        $ptIniciativas = count($ptIniciativas);

        //PROYECTOS POR FASE
        $proyectoFase = DB::table('proyectos')
            ->leftJoin('fases', 'proyectos.id_fase', 'fases.id')
            ->select('proyectos.descripcion as proyecto', 'fases.descripcion as fase', 'proyectos.id_fase')
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
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
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
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
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
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
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
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
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();

        // Operaciones
        $ptfCalidadOperaciones = Proyecto::where('id_enfoque', 1)->where('id_trabajo', 1)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfCalidadOperaciones = count($ptfCalidadOperaciones);
        $ptfGenteOperaciones = Proyecto::where('id_enfoque', 2)->where('id_trabajo', 1)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfGenteOperaciones = count($ptfGenteOperaciones);
        $ptfCostoOperaciones = Proyecto::where('id_enfoque', 3)->where('id_trabajo', 1)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfCostoOperaciones = count($ptfCostoOperaciones);
        $ptfServicioOperaciones = Proyecto::where('id_enfoque', 4)->where('id_trabajo', 1)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfServicioOperaciones = count($ptfServicioOperaciones);
        $ptfCrecimientoOperaciones = Proyecto::where('id_enfoque', 5)->where('id_trabajo', 1)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfCrecimientoOperaciones = count($ptfCrecimientoOperaciones);

        // Administrativo
        $ptfCalidadAdministrativo = Proyecto::where('id_enfoque', 1)->where('id_trabajo', 2)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfCalidadAdministrativo = count($ptfCalidadAdministrativo);
        $ptfGenteAdministrativo = Proyecto::where('id_enfoque', 2)->where('id_trabajo', 2)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfGenteAdministrativo = count($ptfGenteAdministrativo);
        $ptfCostoAdministrativo = Proyecto::where('id_enfoque', 3)->where('id_trabajo', 2)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfCostoAdministrativo = count($ptfCostoAdministrativo);
        $ptfServicioAdministrativo = Proyecto::where('id_enfoque', 4)->where('id_trabajo', 2)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfServicioAdministrativo = count($ptfServicioAdministrativo);
        $ptfCrecimientoAdministrativo = Proyecto::where('id_enfoque', 5)->where('id_trabajo', 2)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfCrecimientoAdministrativo = count($ptfCrecimientoAdministrativo);

        // proyecto
        $ptfCalidadproyecto = Proyecto::where('id_enfoque', 1)->where('id_trabajo', 3)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfCalidadproyecto = count($ptfCalidadproyecto);
        $ptfGenteproyecto = Proyecto::where('id_enfoque', 2)->where('id_trabajo', 3)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfGenteproyecto = count($ptfGenteproyecto);
        $ptfCostoproyecto = Proyecto::where('id_enfoque', 3)->where('id_trabajo', 3)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfCostoproyecto = count($ptfCostoproyecto);
        $ptfServicioproyecto = Proyecto::where('id_enfoque', 4)->where('id_trabajo', 3)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfServicioproyecto = count($ptfServicioproyecto);
        $ptfCrecimientoproyecto = Proyecto::where('id_enfoque', 5)->where('id_trabajo', 3)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfCrecimientoproyecto = count($ptfCrecimientoproyecto);

        // Iniciativas
        $ptfCalidadIniciativas = Proyecto::where('id_enfoque', 1)->where('id_trabajo', 4)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfCalidadIniciativas = count($ptfCalidadIniciativas);
        $ptfGenteIniciativas = Proyecto::where('id_enfoque', 2)->where('id_trabajo', 4)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfGenteIniciativas = count($ptfGenteIniciativas);
        $ptfCostoIniciativas = Proyecto::where('id_enfoque', 3)->where('id_trabajo', 4)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfCostoIniciativas = count($ptfCostoIniciativas);
        $ptfServicioIniciativas = Proyecto::where('id_enfoque', 4)->where('id_trabajo', 4)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $ptfServicioIniciativas = count($ptfServicioIniciativas);
        $ptfCrecimientoIniciativas = Proyecto::where('id_enfoque', 5)->where('id_trabajo', 4)->where('id_compania', Auth::user()->id_compania)->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
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
                    'dataOperaciones', 'dataAdministrativo', 'dataProyectos', 'dataIniciativas', 'direcciones', 'gerencias', 'dir', 'rol'));
    }

    public function toProjectsDir(Request $request) {
        $id_direccion = $request->input('direccion');
        $rol = Auth::user()->id_rol;
        if ($id_direccion == 0) {
            return redirect('/graficas/proyectos');
        }
        $dir = Direccion::find($id_direccion);

        if (Auth::user()->id_rol == 4 || Auth::user()->id_rol == 5 || Auth::user()->id_rol == 2) {
            $direcciones = Direccion::where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = Gerencia::where('id_compania', Auth::user()->id_compania)->get();
        }
        if (Auth::user()->id_rol == 6) {
            $direcciones = Direccion::where('id_director', Auth::user()->id)->where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = DB::table('gerencias')
                ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
                ->select('gerencias.*')
                ->where('direcciones.id_director', Auth::user()->id)
                ->where('gerencias.id_direccion', $dir->id)
                ->where('gerencias.id_compania', Auth::user()->id_compania)
                ->get();
        }
        if (Auth::user()->id_rol == 7) {
            $direcciones = null;
            $gerencias = Gerencia::where('id_gerente', Auth::user()->id)->where('id_compania', Auth::user()->id_compania)
                ->get();
        }

        //PROYECTOS POR ENFOQUE
        $proyectoenfoque = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto', 'enfoques.descripcion as enfoque')
            ->where('direcciones.id', $id_direccion)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $peCalidad = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 1)
            ->where('direcciones.id', $id_direccion)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $peGente = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 2)
            ->where('direcciones.id', $id_direccion)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $peCosto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 3)
            ->where('direcciones.id', $id_direccion)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $peServicio = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 4)
            ->where('direcciones.id', $id_direccion)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $peCrecimiento = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 5)
            ->where('direcciones.id', $id_direccion)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();

        $peCalidad = count($peCalidad);
        $peGente = count($peGente);
        $peCosto = count($peCosto);
        $peServicio = count($peServicio);
        $peCrecimiento = count($peCrecimiento);

        //PROYECTOS POR TRABAJO
        $proyectoTrabajo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto', 'trabajos.descripcion as trabajo')
            ->where('direcciones.id', $id_direccion)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $ptOperaciones = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 1)
            ->where('direcciones.id', $id_direccion)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $ptAdministrativo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 2)
            ->where('direcciones.id', $id_direccion)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $ptProyecto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 3)
            ->where('direcciones.id', $id_direccion)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $ptIniciativas = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 4)
            ->where('direcciones.id', $id_direccion)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();

        $ptOperaciones = count($ptOperaciones);
        $ptAdministrativo = count($ptAdministrativo);
        $ptProyectos = count($ptProyecto);
        $ptIniciativas = count($ptIniciativas);

        //PROYECTOS POR FASE
        $proyectoFase = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('fases', 'proyectos.id_fase', 'fases.id')
            ->select('proyectos.descripcion as proyecto', 'fases.descripcion as fase', 'proyectos.id_fase')
            ->where('direcciones.id', $id_direccion)
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
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('indicadores', 'proyectos.id_indicador', 'indicadores.id')
            ->select('proyectos.descripcion as proyecto', 'indicadores.descripcion as indicador', 'proyectos.id_indicador')
            ->where('direcciones.id', $id_direccion)
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
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('areas', 'proyectos.id_area', 'areas.id')
            ->select('proyectos.descripcion as proyecto', 'areas.descripcion as area', 'proyectos.id_area')
            ->where('direcciones.id', $id_direccion)
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
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('estado', 'proyectos.id_estado', 'estado.id')
            ->select('proyectos.descripcion as proyecto', 'estado.estado as estado', 'proyectos.id_estado')
            ->where('direcciones.id', $id_direccion)
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
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto', 'trabajos.descripcion as trabajo','enfoques.descripcion as enfoque', 'proyectos.id_enfoque', 'proyectos.id_trabajo')
            ->where('direcciones.id', $id_direccion)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();

        // Operaciones
        $ptfCalidadOperaciones = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 1)
            ->where('proyectos.id_trabajo', 1)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfCalidadOperaciones = count($ptfCalidadOperaciones);
        $ptfGenteOperaciones = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 2)
            ->where('proyectos.id_trabajo', 1)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfGenteOperaciones = count($ptfGenteOperaciones);
        $ptfCostoOperaciones = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 3)
            ->where('proyectos.id_trabajo', 1)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfCostoOperaciones = count($ptfCostoOperaciones);
        $ptfServicioOperaciones = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 4)
            ->where('proyectos.id_trabajo', 1)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfServicioOperaciones = count($ptfServicioOperaciones);
        $ptfCrecimientoOperaciones = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 5)
            ->where('proyectos.id_trabajo', 1)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfCrecimientoOperaciones = count($ptfCrecimientoOperaciones);

        // Administrativo
        $ptfCalidadAdministrativo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 1)
            ->where('proyectos.id_trabajo', 2)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfCalidadAdministrativo = count($ptfCalidadAdministrativo);
        $ptfGenteAdministrativo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 2)
            ->where('proyectos.id_trabajo', 2)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfGenteAdministrativo = count($ptfGenteAdministrativo);
        $ptfCostoAdministrativo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 3)
            ->where('proyectos.id_trabajo', 2)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfCostoAdministrativo = count($ptfCostoAdministrativo);
        $ptfServicioAdministrativo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 4)
            ->where('proyectos.id_trabajo', 2)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfServicioAdministrativo = count($ptfServicioAdministrativo);
        $ptfCrecimientoAdministrativo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 5)
            ->where('proyectos.id_trabajo', 2)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfCrecimientoAdministrativo = count($ptfCrecimientoAdministrativo);

        // proyecto
        $ptfCalidadproyecto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 1)
            ->where('proyectos.id_trabajo', 3)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfCalidadproyecto = count($ptfCalidadproyecto);
        $ptfGenteproyecto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 2)
            ->where('proyectos.id_trabajo', 3)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfGenteproyecto = count($ptfGenteproyecto);
        $ptfCostoproyecto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 3)
            ->where('proyectos.id_trabajo', 3)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfCostoproyecto = count($ptfCostoproyecto);
        $ptfServicioproyecto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 4)
            ->where('proyectos.id_trabajo', 3)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfServicioproyecto = count($ptfServicioproyecto);
        $ptfCrecimientoproyecto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 5)
            ->where('proyectos.id_trabajo', 3)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfCrecimientoproyecto = count($ptfCrecimientoproyecto);

        // Iniciativas
        $ptfCalidadIniciativas = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 1)
            ->where('proyectos.id_trabajo', 4)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfCalidadIniciativas = count($ptfCalidadIniciativas);
        $ptfGenteIniciativas = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 2)
            ->where('proyectos.id_trabajo', 4)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfGenteIniciativas = count($ptfGenteIniciativas);
        $ptfCostoIniciativas = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 3)
            ->where('proyectos.id_trabajo', 4)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfCostoIniciativas = count($ptfCostoIniciativas);
        $ptfServicioIniciativas = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 4)
            ->where('proyectos.id_trabajo', 4)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
        $ptfServicioIniciativas = count($ptfServicioIniciativas);
        $ptfCrecimientoIniciativas = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 5)
            ->where('proyectos.id_trabajo', 4)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('direcciones.id', $id_direccion)
            ->get();
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
            'dataOperaciones', 'dataAdministrativo', 'dataProyectos', 'dataIniciativas', 'direcciones', 'gerencias', 'dir', 'rol'));
    }

    public function toProjectsGer(Request $request) {
        $id_gerencia = $request->input('gerencia');
        if ($id_gerencia == 0) {
            return redirect('/graficas/proyectos');
        }
        $rol = Auth::user()->id_rol;
        $ger = Gerencia::find($id_gerencia);
        $id_direccion = $ger->id_direccion;
        $dir = Direccion::find($id_direccion);

        if (Auth::user()->id_rol == 4 || Auth::user()->id_rol == 5 || Auth::user()->id_rol == 2) {
            $direcciones = Direccion::where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = Gerencia::where('id_compania', Auth::user()->id_compania)->get();
        }
        if (Auth::user()->id_rol == 6) {
            $direcciones = Direccion::where('id_director', Auth::user()->id)->where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = DB::table('gerencias')
                ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
                ->select('gerencias.*')
                ->where('direcciones.id_director', Auth::user()->id)
                ->where('gerencias.id_direccion', $dir->id)
                ->where('gerencia.id_compania', Auth::user()->id_compania)
                ->get();
        }
        if (Auth::user()->id_rol == 7) {
            $direcciones = null;
            $gerencias = Gerencia::where('id_gerente', Auth::user()->id)
                ->where('id_compania', Auth::user()->id_compania)
                ->get();
        }

        //PROYECTOS POR ENFOQUE
        $proyectoenfoque = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto', 'enfoques.descripcion as enfoque')
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $peCalidad = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 1)
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $peGente = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 2)
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $peCosto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 3)
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $peServicio = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 4)
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $peCrecimiento = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('enfoques.id', 5)
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();

        $peCalidad = count($peCalidad);
        $peGente = count($peGente);
        $peCosto = count($peCosto);
        $peServicio = count($peServicio);
        $peCrecimiento = count($peCrecimiento);

        //PROYECTOS POR TRABAJO
        $proyectoTrabajo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto', 'trabajos.descripcion as trabajo')
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $ptOperaciones = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 1)
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $ptAdministrativo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 2)
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $ptProyecto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 3)
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();
        $ptIniciativas = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->select('proyectos.descripcion as proyecto')
            ->where('trabajos.id', 4)
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();

        $ptOperaciones = count($ptOperaciones);
        $ptAdministrativo = count($ptAdministrativo);
        $ptProyectos = count($ptProyecto);
        $ptIniciativas = count($ptIniciativas);

        //PROYECTOS POR FASE
        $proyectoFase = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('fases', 'proyectos.id_fase', 'fases.id')
            ->select('proyectos.descripcion as proyecto', 'fases.descripcion as fase', 'proyectos.id_fase')
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
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
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('indicadores', 'proyectos.id_indicador', 'indicadores.id')
            ->select('proyectos.descripcion as proyecto', 'indicadores.descripcion as indicador', 'proyectos.id_indicador')
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
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
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('areas', 'proyectos.id_area', 'areas.id')
            ->select('proyectos.descripcion as proyecto', 'areas.descripcion as area', 'proyectos.id_area')
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
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
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('estado', 'proyectos.id_estado', 'estado.id')
            ->select('proyectos.descripcion as proyecto', 'estado.estado as estado', 'proyectos.id_estado')
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
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
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('trabajos', 'proyectos.id_trabajo', 'trabajos.id')
            ->leftJoin('enfoques', 'proyectos.id_enfoque', 'enfoques.id')
            ->select('proyectos.descripcion as proyecto', 'trabajos.descripcion as trabajo','enfoques.descripcion as enfoque', 'proyectos.id_enfoque', 'proyectos.id_trabajo')
            ->where('gerencias.id', $id_gerencia)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->get();

        // Operaciones
        $ptfCalidadOperaciones = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 1)
            ->where('proyectos.id_trabajo', 1)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfCalidadOperaciones = count($ptfCalidadOperaciones);
        $ptfGenteOperaciones = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 2)
            ->where('proyectos.id_trabajo', 1)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfGenteOperaciones = count($ptfGenteOperaciones);
        $ptfCostoOperaciones = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 3)
            ->where('proyectos.id_trabajo', 1)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfCostoOperaciones = count($ptfCostoOperaciones);
        $ptfServicioOperaciones = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 4)
            ->where('proyectos.id_trabajo', 1)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfServicioOperaciones = count($ptfServicioOperaciones);
        $ptfCrecimientoOperaciones = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 5)
            ->where('proyectos.id_trabajo', 1)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfCrecimientoOperaciones = count($ptfCrecimientoOperaciones);

        // Administrativo
        $ptfCalidadAdministrativo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 1)
            ->where('proyectos.id_trabajo', 2)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfCalidadAdministrativo = count($ptfCalidadAdministrativo);
        $ptfGenteAdministrativo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 2)
            ->where('proyectos.id_trabajo', 2)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfGenteAdministrativo = count($ptfGenteAdministrativo);
        $ptfCostoAdministrativo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 3)
            ->where('proyectos.id_trabajo', 2)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfCostoAdministrativo = count($ptfCostoAdministrativo);
        $ptfServicioAdministrativo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 4)
            ->where('proyectos.id_trabajo', 2)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfServicioAdministrativo = count($ptfServicioAdministrativo);
        $ptfCrecimientoAdministrativo = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 5)
            ->where('proyectos.id_trabajo', 2)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfCrecimientoAdministrativo = count($ptfCrecimientoAdministrativo);

        // proyecto
        $ptfCalidadproyecto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 1)
            ->where('proyectos.id_trabajo', 3)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfCalidadproyecto = count($ptfCalidadproyecto);
        $ptfGenteproyecto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 2)
            ->where('proyectos.id_trabajo', 3)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfGenteproyecto = count($ptfGenteproyecto);
        $ptfCostoproyecto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 3)
            ->where('proyectos.id_trabajo', 3)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfCostoproyecto = count($ptfCostoproyecto);
        $ptfServicioproyecto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 4)
            ->where('proyectos.id_trabajo', 3)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfServicioproyecto = count($ptfServicioproyecto);
        $ptfCrecimientoproyecto = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 5)
            ->where('proyectos.id_trabajo', 3)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfCrecimientoproyecto = count($ptfCrecimientoproyecto);

        // Iniciativas
        $ptfCalidadIniciativas = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 1)
            ->where('proyectos.id_trabajo', 4)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfCalidadIniciativas = count($ptfCalidadIniciativas);
        $ptfGenteIniciativas = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 2)
            ->where('proyectos.id_trabajo', 4)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfGenteIniciativas = count($ptfGenteIniciativas);
        $ptfCostoIniciativas = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 3)
            ->where('proyectos.id_trabajo', 4)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfCostoIniciativas = count($ptfCostoIniciativas);
        $ptfServicioIniciativas = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 4)
            ->where('proyectos.id_trabajo', 4)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
        $ptfServicioIniciativas = count($ptfServicioIniciativas);
        $ptfCrecimientoIniciativas = DB::table('proyectos')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->where('proyectos.id_enfoque', 5)
            ->where('proyectos.id_trabajo', 4)
            ->where('proyectos.id_compania', Auth::user()->id_compania)
            ->where('gerencias.id', $id_gerencia)
            ->get();
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
            'dataOperaciones', 'dataAdministrativo', 'dataProyectos', 'dataIniciativas', 'direcciones', 'gerencias', 'dir', 'rol', 'ger'));
    }

    public function toActivities()
    {
        $dir = null;
        $rol = Auth::user()->id_rol;
        if (Auth::user()->id_rol == 4 || Auth::user()->id_rol == 5 || Auth::user()->id_rol == 2) {
            $direcciones = Direccion::where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = Gerencia::where('id_compania', Auth::user()->id_compania)->get();
        }
        if (Auth::user()->id_rol == 6) {
            $direcciones = Direccion::where('id_director', Auth::user()->id)->where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = DB::table('gerencias')
                ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
                ->select('gerencias.*')
                ->where('direcciones.id_director', Auth::user()->id)
                ->where('gerencias.id_compania', Auth::user()->id_compania)
                ->get();
        }
        if (Auth::user()->id_rol == 7) {
            $direcciones = null;
            $gerencias = Gerencia::where('id_gerente', Auth::user()->id)
                ->where('id_compania', Auth::user()->id_compania)
                ->get();
        }

        //ACTIVIDADES POR PROYECTO
        $Actividadesproyecto = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->select('actividades.descricion as actividad', 'proyectos.descripcion as proyecto', 'actividades.id_proyecto')
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
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
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->select('actividades.descricion as actividad','actividades.estado as activo')
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();

        $aePendiente = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->select('actividades.descricion as actividad')
            ->where('actividades.estado', 0)
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $aeAprobada = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->select('actividades.descricion as actividad')
            ->where('actividades.estado', 1)
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();
        $aeDesaprobada = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->select('actividades.descricion as actividad')
            ->where('actividades.estado', 2)
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
            ->get();

        $aePendiente = count($aePendiente);
        $aeAprobada = count($aeAprobada);
        $aeDesaprobada = count($aeDesaprobada);

        //ACTIVIDADES POR USUARIO
        $ActividadesUsuarios = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('usuarios', 'actividades.id_usuario', 'usuarios.id')
            ->select('actividades.descricion as actividad', 'usuarios.nombres as usuario', 'actividades.id_usuario')
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
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
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('etapas', 'actividades.id_etapa', 'etapas.id')
            ->select('actividades.descricion as actividad', 'etapas.descripcion as etapa', 'actividades.id_etapa')
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->where(function($query) use ($gerencias) {
                if ($gerencias != null) {
                    $query->whereIn('proyectos.id_gerencia', $gerencias);
                }
            })
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
            'total','compania','Actividadesproyecto','proyectos', 'conteoproyecto','ActividadesEstado','aePendiente','aeAprobada', 'aeDesaprobada', 'direcciones', 'gerencias', 'rol', 'dir'));
    }

    public function toActivitiesDir(Request $request)
    {
        $id_direccion = $request->input('direccion');
        $rol = Auth::user()->id_rol;
        if ($id_direccion == 0) {
            return redirect('/graficas/actividades');
        }
        $dir = Direccion::find($id_direccion);

        if (Auth::user()->id_rol == 4 || Auth::user()->id_rol == 5) {
            $direcciones = Direccion::where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = Gerencia::where('id_compania', Auth::user()->id_compania)->get();
        }
        if (Auth::user()->id_rol == 6) {
            $direcciones = Direccion::where('id_director', Auth::user()->id)->where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = DB::table('gerencias')
                ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
                ->select('gerencias.*')
                ->where('direcciones.id_director', Auth::user()->id)
                ->where('gerencias.id_direccion', $dir->id)
                ->where('gerencias.id_compania', Auth::user()->id_compania)
                ->get();
        }
        if (Auth::user()->id_rol == 7) {
            $direcciones = null;
            $gerencias = Gerencia::where('id_gerente', Auth::user()->id)
                ->where('id_compania', Auth::user()->id_compania)
                ->get();
        }

        //ACTIVIDADES POR PROYECTO
        $Actividadesproyecto = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->select('actividades.descricion as actividad', 'proyectos.descripcion as proyecto', 'actividades.id_proyecto')
            ->where('direcciones.id', $id_direccion)
            ->where('actividades.id_compania', Auth::user()->id_compania)
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
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->select('actividades.descricion as actividad','actividades.estado as activo')
            ->where('direcciones.id', $id_direccion)
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->get();

        $aePendiente = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->select('actividades.descricion as actividad')
            ->where('actividades.estado', 0)
            ->where('direcciones.id', $id_direccion)
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->get();
        $aeAprobada = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->select('actividades.descricion as actividad')
            ->where('actividades.estado', 1)
            ->where('direcciones.id', $id_direccion)
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->get();
        $aeDesaprobada = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->select('actividades.descricion as actividad')
            ->where('actividades.estado', 2)
            ->where('direcciones.id', $id_direccion)
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->get();

        $aePendiente = count($aePendiente);
        $aeAprobada = count($aeAprobada);
        $aeDesaprobada = count($aeDesaprobada);

        //ACTIVIDADES POR USUARIO
        $ActividadesUsuarios = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('usuarios', 'actividades.id_usuario', 'usuarios.id')
            ->select('actividades.descricion as actividad', 'usuarios.nombres as usuario', 'actividades.id_usuario')
            ->where('direcciones.id', $id_direccion)
            ->where('actividades.id_compania', Auth::user()->id_compania)
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
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('etapas', 'actividades.id_etapa', 'etapas.id')
            ->select('actividades.descricion as actividad', 'etapas.descripcion as etapa', 'actividades.id_etapa')
            ->where('direcciones.id', $id_direccion)
            ->where('actividades.id_compania', Auth::user()->id_compania)
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
            'total','compania','Actividadesproyecto','proyectos', 'conteoproyecto','ActividadesEstado','aePendiente','aeAprobada', 'aeDesaprobada', 'direcciones', 'gerencias', 'rol', 'dir'));
    }

    public function toActivitiesGer(Request $request)
    {
        $id_gerencia = $request->input('gerencia');
        if ($id_gerencia == 0) {
            return redirect('/graficas/actividades');
        }
        $rol = Auth::user()->id_rol;
        $ger = Gerencia::find($id_gerencia);
        $id_direccion = $ger->id_direccion;
        $dir = Direccion::find($id_direccion);

        if (Auth::user()->id_rol == 4 || Auth::user()->id_rol == 5) {
            $direcciones = Direccion::where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = Gerencia::where('id_compania', Auth::user()->id_compania)->get();
        }
        if (Auth::user()->id_rol == 6) {
            $direcciones = Direccion::where('id_director', Auth::user()->id)->where('id_compania', Auth::user()->id_compania)->get();
            $gerencias = DB::table('gerencias')
                ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
                ->select('gerencias.*')
                ->where('direcciones.id_director', Auth::user()->id)
                ->where('gerencias.id_direccion', $dir->id)
                ->where('gerencias.id_compania', Auth::user()->id_compania)
                ->get();
        }
        if (Auth::user()->id_rol == 7) {
            $direcciones = null;
            $gerencias = Gerencia::where('id_gerente', Auth::user()->id)
                ->where('id_compania', Auth::user()->id_compania)
                ->get();
        }

        //ACTIVIDADES POR PROYECTO
        $Actividadesproyecto = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->select('actividades.descricion as actividad', 'proyectos.descripcion as proyecto', 'actividades.id_proyecto')
            ->where('gerencias.id', $id_gerencia)
            ->where('actividades.id_compania', Auth::user()->id_compania)
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
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->select('actividades.descricion as actividad','actividades.estado as activo')
            ->where('gerencias.id', $id_gerencia)
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->get();

        $aePendiente = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->select('actividades.descricion as actividad')
            ->where('actividades.estado', 0)
            ->where('gerencias.id', $id_gerencia)
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->get();
        $aeAprobada = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->select('actividades.descricion as actividad')
            ->where('actividades.estado', 1)
            ->where('gerencias.id', $id_gerencia)
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->get();
        $aeDesaprobada = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->select('actividades.descricion as actividad')
            ->where('actividades.estado', 2)
            ->where('gerencias.id', $id_gerencia)
            ->where('actividades.id_compania', Auth::user()->id_compania)
            ->get();

        $aePendiente = count($aePendiente);
        $aeAprobada = count($aeAprobada);
        $aeDesaprobada = count($aeDesaprobada);

        //ACTIVIDADES POR USUARIO
        $ActividadesUsuarios = DB::table('actividades')
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('usuarios', 'actividades.id_usuario', 'usuarios.id')
            ->select('actividades.descricion as actividad', 'usuarios.nombres as usuario', 'actividades.id_usuario')
            ->where('gerencias.id', $id_gerencia)
            ->where('actividades.id_compania', Auth::user()->id_compania)
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
            ->leftJoin('proyectos', 'actividades.id_proyecto', 'proyectos.id')
            ->leftJoin('gerencias', 'gerencias.id', 'proyectos.id_gerencia')
            ->leftJoin('direcciones', 'direcciones.id', 'gerencias.id_direccion')
            ->leftJoin('etapas', 'actividades.id_etapa', 'etapas.id')
            ->select('actividades.descricion as actividad', 'etapas.descripcion as etapa', 'actividades.id_etapa')
            ->where('gerencias.id', $id_gerencia)
            ->where('actividades.id_compania', Auth::user()->id_compania)
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
            'total','compania','Actividadesproyecto','proyectos', 'conteoproyecto','ActividadesEstado','aePendiente','aeAprobada', 'aeDesaprobada', 'direcciones', 'gerencias', 'rol', 'dir', 'ger'));
    }
}
