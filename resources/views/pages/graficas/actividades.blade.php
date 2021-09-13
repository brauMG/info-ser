@extends('layouts.app', ['activePage' => 'ActividadesCharts', 'titlePage' => __('Actividades Reporte')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if ( session('mensaje') )
                        <div class="alert alert-success" role="alert" id="message">
                            {{ session('mensaje') }}
                        </div>
                    @endif
                    @if ( session('mensajeAlert') )
                        <div class="alert alert-warning" role="alert" id="message">
                            {{ session('mensajeAlert') }}
                        </div>
                    @endif
                    @if ( session('mensajeDanger') )
                        <div class="alert alert-danger" role="alert" id="message">
                            {{ session('mensajeDanger') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert" id="message">
                            Se encontraron los siguientes errores: <br>
                            @foreach($errors->all() as $error)
                                <br>
                                {{'• '.$error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <div style="display: flex; flex-wrap: wrap">
                                @if($rol != 7)
                                    <div class="col-md-4">
                                        <form action="{{route('ChartsActivitiesDir')}}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label class="text-white">Dirección</label>
                                                <select class="custom-select" name="direccion" style="width: 250px">
                                                    <option value="0">Todas</option>
                                                    @foreach($direcciones as $direccion)
                                                        @if($dir != null)
                                                            @if($dir->id == $direccion->id)
                                                                <option value="{{$direccion->id}}" selected>{{$direccion->nombre}}</option>
                                                            @else
                                                                <option value="{{$direccion->id}}">{{$direccion->nombre}}</option>
                                                            @endif
                                                        @else
                                                            <option value="{{$direccion->id}}">{{$direccion->nombre}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-info"><i class="material-icons">sort</i>Filtrar</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                                <div class="col-md-4">
                                    <form action="{{route('ChartsActivitiesGer')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label class="text-white">Gerencia</label>
                                            <select class="custom-select" name="gerencia" style="width: 250px">
                                                @if($rol == 7)
                                                    <option value="0">Todas</option>
                                                @endif
                                                    @foreach($gerencias as $gerencia)
                                                        @if($ger->id == $gerencia->id)
                                                            <option value="{{$gerencia->id}}" selected>{{$gerencia->nombre}}</option>
                                                        @else
                                                            <option value="{{$gerencia->id}}">{{$gerencia->nombre}}</option>
                                                        @endif
                                                    @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-info"><i class="material-icons">sort</i>Filtrar</button>
                                        </div>
                                    </form>
                                </div>
                                @if($dir != null)
                                    <div class="col-md-4">
                                        <label class="text-white" style="float: right">Viendo resultados de la dirección: <strong>{{$dir->nombre}}@if(isset($ger)), gerencia: {{$ger->nombre}}@endif</strong></label>
                                    </div>
                                @else
                                    <div class="col-md-4">
                                        <label class="text-white" style="float: right">Viendo resultados de todas las direcciones</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title">Actividades por proyecto</h4>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Actividades:</strong> {{count($Actividadesproyecto)}}</p>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Proyectos:</strong> {{count($proyectos)}}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                    <div class="col-md-6 charts-list-scroll">
                                        <table class="table-bordered table-striped charts-table">
                                            <thead>
                                            <tr>
                                                <th><i class="material-icons icons-charts-list">task</i> Actividad</th>
                                                <th><i class="material-icons icons-charts-list">auto_stories</i> Proyecto</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Actividadesproyecto as $AP)
                                                <tr>
                                                    <td><i class="material-icons icons-charts-list">fact_check</i> {{$AP->actividad}}</td>
                                                    <td><i class="material-icons icons-charts-list">flag</i> {{$AP->proyecto}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                <div class="col-md-6" style="height: 35vh">
                                    <canvas id="ActivitiesProject"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title">Actividades por estado</h4>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Actividades:</strong> {{count($Actividadesproyecto)}}</p>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Estados:</strong> 3</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 charts-list-scroll">
                                    <table class="table-bordered table-striped charts-table">
                                        <thead>
                                        <tr>
                                            <th><i class="material-icons icons-charts-list">task</i> Actividad</th>
                                            <th><i class="material-icons icons-charts-list">theater_comedy</i> Estado</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($ActividadesEstado as $AE)
                                            <tr>
                                                <td><i class="material-icons icons-charts-list">fact_check</i> {{$AE->actividad}}</td>
                                                @if($AE->activo == 0)
                                                    <td><i class="material-icons icons-charts-list text-warning">contact_support</i> Pendiente</td>
                                                @elseif($AE->activo == 1)
                                                    <td><i class="material-icons icons-charts-list text-success">fact_check</i> Aprobada</td>
                                                @else
                                                    <td><i class="material-icons icons-charts-list text-danger">dangerous</i>  Desaprobada</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6" style="height: 35vh">
                                    <canvas id="ActivitiesStatus"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title">Actividades por usuario</h4>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Actividades:</strong> {{count($Actividadesproyecto)}}</p>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Usuarios:</strong> {{count($usuarios)}}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 charts-list-scroll">
                                    <table class="table-bordered table-striped charts-table">
                                        <thead>
                                        <tr>
                                            <th><i class="material-icons icons-charts-list">task</i> Actividad</th>
                                            <th><i class="material-icons icons-charts-list">person_pin</i> Usuario</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($ActividadesUsuarios as $AU)
                                            <tr>
                                                <td><i class="material-icons icons-charts-list">fact_check</i> {{$AU->actividad}}</td>
                                                <td><i class="material-icons icons-charts-list">verified_user</i> {{$AU->usuario}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6" style="height: 35vh">
                                    <canvas id="ActivitiesUser"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title">Actividades por etapa</h4>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Actividades:</strong> {{count($Actividadesproyecto)}}</p>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Etapas:</strong> {{count($etapas)}}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 charts-list-scroll">
                                    <table class="table-bordered table-striped charts-table">
                                        <thead>
                                        <tr>
                                            <th><i class="material-icons icons-charts-list">task</i> Actividad</th>
                                            <th><i class="material-icons icons-charts-list">push_pin</i> Etapa</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($ActividadesEtapas as $AE)
                                            <tr>
                                                <td><i class="material-icons icons-charts-list">fact_check</i> {{$AE->actividad}}</td>
                                                <td><i class="material-icons icons-charts-list">edit_attributes</i> {{$AE->etapa}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6" style="height: 35vh">
                                    <canvas id="ActivitiesStage"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <script>
        //Para Charts 1
        var coloR1 = [];

        var dynamicColors1 = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            if(r < 100) {
                r = r + 100;
            }
            if(g < 100) {
                g = g + 100;
            }
            if(b < 100) {
                b = b + 100;
            }
            return "rgb(" + r + "," + g + "," + b + ")";
        };

            @foreach($conteoproyecto as $conteo)
                coloR1.push(dynamicColors1());
            @endforeach

        //Para Charts 3
        var coloR3 = [];

        var dynamicColors3 = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            if(r < 100) {
                r = r + 100;
            }
            if(g < 100) {
                g = g + 100;
            }
            if(b < 100) {
                b = b + 100;
            }
            return "rgb(" + r + "," + g + "," + b + ")";
        };

            @foreach($conteoUsuarios as $conteo)
                coloR3.push(dynamicColors3());
            @endforeach

        //Para Charts Etapas
        var coloR4 = [];

        var dynamicColors4 = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            if(r < 100) {
                r = r + 50;
            }
            if(g < 100) {
                g = g + 50;
            }
            if(b < 100) {
                b = b + 50;
            }
            return "rgb(" + r + "," + g + "," + b + ")";
        };

            @foreach($conteoEtapas as $conteo)
                coloR4.push(dynamicColors4());
            @endforeach

        var ctx = document.getElementById("ActivitiesProject");
        var ctx1 = document.getElementById("ActivitiesStatus");
        var ctx2 = document.getElementById("ActivitiesUser");
        var ctx3 = document.getElementById("ActivitiesStage");
        var total = @json($total);

        var lineChart = new Chart(ctx, {
            type: 'doughnut',
            plugins: [ChartDataLabels],
            data: {
                labels: [
                    @foreach($proyectos as $proyecto)
                        "{{$proyecto}}",
                    @endforeach
                ],
                datasets: [{
                    data:
                        [
                            @foreach($conteoproyecto as $conteo)
                                "{{$conteo}}",
                            @endforeach
                        ],
                    backgroundColor: coloR1,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        anchor: 'center',
                        align: 'center',
                        formatter: (value, ctx) => {
                            let sum = 0;
                            let dataArr = ctx.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(0)+"%";
                            return percentage;
                        },
                        color: '#333333',
                        font: {
                            weight: 'bold',
                            size: '13',
                        },
                    },
                    legend: {
                        position: 'bottom',
                        align: 'center',
                        display: true,
                    },
                    tooltip: {
                        backgroundColor: '#0087bd',
                        bodyColor: '#f8fff9',
                    }
                }
            }
        });

        var lineChart1 = new Chart(ctx1, {
            type: 'doughnut',
            plugins: [ChartDataLabels],
            data: {
                labels: [
                    @if ($aePendiente > 0)
                        'Pendientes',
                    @endif
                        @if ($aeAprobada > 0)
                        'Aprobadas',
                    @endif
                        @if ($aeDesaprobada > 0)
                        'Desaprobadas',
                    @endif
                ],
                datasets: [{
                    data:
                        [
                            @if ($aePendiente > 0)
                            {{$aePendiente}},
                            @endif
                            @if ($aeAprobada > 0)
                            {{$aeAprobada}},
                            @endif
                            @if ($aeDesaprobada > 0)
                            {{$aeDesaprobada}},
                            @endif
                        ],
                    backgroundColor: ['#e9c542', '#00bb26', '#ff2321'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        anchor: 'center',
                        align: 'center',
                        formatter: (value, ctx1) => {
                            let sum = 0;
                            let dataArr = ctx1.chart.data.datasets[0].data;
                            let percentage = (value * 100 / total).toFixed(2) + "%";
                            return percentage;
                        },
                        color: '#333333',
                        font: {
                            weight: 'bold',
                            size: '13',
                        },
                    },
                    legend: {
                        position: 'bottom',
                        align: 'center',
                        display: true,
                    },
                    tooltip: {
                        backgroundColor: '#0087bd',
                        bodyColor: '#f8fff9',
                    }
                }
            }
        });

        var lineChart2 = new Chart(ctx2, {
            type: 'doughnut',
            plugins: [ChartDataLabels],
            data: {
                labels: [
                    @foreach($usuarios as $usuario)
                        "{{$usuario}}",
                    @endforeach
                ],
                datasets: [{
                    data:
                        [
                            @foreach($conteoUsuarios as $conteo)
                                "{{$conteo}}",
                            @endforeach
                        ],
                    backgroundColor: coloR3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        anchor: 'center',
                        align: 'center',
                        formatter: (value, ctx) => {
                            let sum = 0;
                            let dataArr = ctx.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(0)+"%";
                            return percentage;
                        },
                        color: '#333333',
                        font: {
                            weight: 'bold',
                            size: '13',
                        },
                    },
                    legend: {
                        position: 'bottom',
                        align: 'center',
                        display: true,
                    },
                    tooltip: {
                        backgroundColor: '#0087bd',
                        bodyColor: '#f8fff9',
                    }
                }
            }
        });

        var lineChart3 = new Chart(ctx3, {
            type: 'doughnut',
            plugins: [ChartDataLabels],
            data: {
                labels: [
                    @foreach($etapas as $etapa)
                        "{{$etapa}}",
                    @endforeach
                ],
                datasets: [{
                    data:
                        [
                            @foreach($conteoEtapas as $conteo)
                                "{{$conteo}}",
                            @endforeach
                        ],
                    backgroundColor: coloR4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        anchor: 'center',
                        align: 'center',
                        formatter: (value, ctx) => {
                            let sum = 0;
                            let dataArr = ctx.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(0)+"%";
                            return percentage;
                        },
                        color: '#333333',
                        font: {
                            weight: 'bold',
                            size: '13',
                        },
                    },
                    legend: {
                        position: 'bottom',
                        align: 'center',
                        display: true,
                    },
                    tooltip: {
                        backgroundColor: '#0087bd',
                        bodyColor: '#f8fff9',
                    }
                }
            }
        });
    </script>
@endsection

