@extends('layouts.app', ['activePage' => 'ProyectosCharts', 'titlePage' => __('Proyectos Reporte')])

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
                                <div class="col-md-4">
                                    <form action="{{route('ChartsProjectsDir')}}" method="POST">
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
                                <div class="col-md-4">
                                    <form action="{{route('ChartsProjectsGer')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label class="text-white">Gerencia</label>
                                            <select class="custom-select" name="gerencia" style="width: 250px">
                                                @foreach($gerencias as $gerencia)
                                                    <option value="{{$gerencia->id}}">{{$gerencia->nombre}}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-info"><i class="material-icons">sort</i>Filtrar</button>
                                        </div>
                                    </form>
                                </div>
                                @if($dir != null)
                                    <div class="col-md-4">
                                        <label class="text-white" style="float: right">Viendo resultados de la dirección: <strong>{{$dir->nombre}}</strong></label>
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

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Actividades de trabajo por enfoque y tipo de trabajo</h4>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Proyectos:</strong> {{count($proyectoenfoque)}}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 charts-list-scroll">
                                    <table class="table-bordered table-striped charts-table">
                                        <thead>
                                        <tr>
                                            <th><i class="material-icons icons-charts-list">auto_stories</i> Proyecto</th>
                                            <th><i class="material-icons icons-charts-list">work</i> Trabajo</th>
                                            <th><i class="material-icons icons-charts-list">loupe</i> Enfoque</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($proyectotrabajoenfoque as $PTE)
                                            <tr>
                                                <td><i class="material-icons icons-charts-list">fact_check</i> {{$PTE->proyecto}}</td>
                                                <td><i class="material-icons icons-charts-list">engineering</i> {{$PTE->trabajo}}</td>
                                                <td><i class="material-icons icons-charts-list">share</i> {{$PTE->enfoque}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6" style="height: 35vh">
                                    <canvas id="ChartFocusJob"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title">Actividades de trabajo por enfoque</h4>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Proyectos:</strong> {{count($proyectoenfoque)}}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 charts-list-scroll">
                                    <table class="table-bordered table-striped charts-table">
                                        <thead>
                                        <tr>
                                            <th><i class="material-icons icons-charts-list">auto_stories</i> Proyecto</th>
                                            <th><i class="material-icons icons-charts-list">loupe</i> Enfoque</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($proyectoenfoque as $PE)
                                            <tr>
                                                <td><i class="material-icons icons-charts-list">fact_check</i> {{$PE->proyecto}}</td>
                                                <td><i class="material-icons icons-charts-list">share</i> {{$PE->enfoque}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6" style="height: 35vh">
                                    <canvas id="ChartFocus"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title">Actividades de trabajo por tipo de trabajo</h4>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Proyectos:</strong> {{count($proyectoenfoque)}}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 charts-list-scroll">
                                    <table class="table-bordered table-striped charts-table">
                                        <thead>
                                        <tr>
                                            <th><i class="material-icons icons-charts-list">auto_stories</i> Proyecto</th>
                                            <th><i class="material-icons icons-charts-list">work</i> Trabajo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($proyectoTrabajo as $PT)
                                            <tr>
                                                <td><i class="material-icons icons-charts-list">fact_check</i> {{$PT->proyecto}}</td>
                                                <td><i class="material-icons icons-charts-list">engineering</i> {{$PT->trabajo}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6" style="height: 35vh">
                                    <canvas id="ChartJob"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-rose">
                            <h4 class="card-title">Actividades de trabajo por fase</h4>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Proyectos:</strong> {{count($proyectoenfoque)}}</p>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Fases:</strong> {{count($fases)}}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 charts-list-scroll">
                                    <table class="table-bordered table-striped charts-table">
                                        <thead>
                                        <tr>
                                            <th><i class="material-icons icons-charts-list">auto_stories</i> Proyecto</th>
                                            <th><i class="material-icons icons-charts-list">push_pin</i> Fases</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($proyectoFase as $PF)
                                            <tr>
                                                <td><i class="material-icons icons-charts-list">fact_check</i> {{$PF->proyecto}}</td>
                                                <td><i class="material-icons icons-charts-list">edit_attributes</i> {{$PF->fase}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6" style="height: 35vh">
                                    <canvas id="ChartStage"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-rose">
                            <h4 class="card-title">Actividades de trabajo por indicador</h4>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Proyectos:</strong> {{count($proyectoenfoque)}}</p>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Indicadores:</strong> {{count($indicadores)}}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 charts-list-scroll">
                                    <table class="table-bordered table-striped charts-table">
                                        <thead>
                                        <tr>
                                            <th><i class="material-icons icons-charts-list">auto_stories</i> Proyecto</th>
                                            <th><i class="material-icons icons-charts-list">plagiarism</i> Indicadores</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($proyectoIndicador as $PI)
                                            <tr>
                                                <td><i class="material-icons icons-charts-list">fact_check</i> {{$PI->proyecto}}</td>
                                                <td><i class="material-icons icons-charts-list">send</i> {{$PI->indicador}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6" style="height: 35vh">
                                    <canvas id="ChartIndicator"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Actividades de trabajo por área</h4>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Proyectos:</strong> {{count($proyectoenfoque)}}</p>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Áreas:</strong> {{count($areas)}}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 charts-list-scroll">
                                    <table class="table-bordered table-striped charts-table">
                                        <thead>
                                        <tr>
                                            <th><i class="material-icons icons-charts-list">auto_stories</i> Proyecto</th>
                                            <th><i class="material-icons icons-charts-list">account_tree</i> Áreas</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($proyectoArea as $PA)
                                            <tr>
                                                <td><i class="material-icons icons-charts-list">fact_check</i> {{$PA->proyecto}}</td>
                                                <td><i class="material-icons icons-charts-list">area_chart</i> {{$PA->area}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6" style="height: 35vh">
                                    <canvas id="ChartArea"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Actividades de trabajo por estado</h4>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Proyectos:</strong> {{count($proyectoenfoque)}}</p>
                            <p class="card-category"><i class="material-icons">scatter_plot</i> <strong>Total de Estados:</strong> {{count($estados)}}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 charts-list-scroll">
                                    <table class="table-bordered table-striped charts-table">
                                        <thead>
                                        <tr>
                                            <th><i class="material-icons icons-charts-list">auto_stories</i> Proyecto</th>
                                            <th><i class="material-icons icons-charts-list">theater_comedy</i> Estados</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($proyectoEstado as $PE)
                                            <tr>
                                                <td><i class="material-icons icons-charts-list">fact_check</i> {{$PE->proyecto}}</td>
                                                <td><i class="material-icons icons-charts-list">preview</i> {{$PE->estado}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6" style="height: 35vh">
                                    <canvas id="ChartStatus"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <script>
        //Para ctx3
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

            @foreach($conteofases as $conteo)
                coloR3.push(dynamicColors3());
            @endforeach

        //Para ctx4
        var coloR4 = [];

        var dynamicColors4 = function() {
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

        @foreach($conteoIndicadores as $conteo)
        coloR4.push(dynamicColors4());
            @endforeach

        //Para ctx5
        var coloR5 = [];

        var dynamicColors5 = function() {
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

        @foreach($conteoAreas as $conteo)
        coloR5.push(dynamicColors5());
            @endforeach

        //Para ctx6
        var coloR6 = [];

        var dynamicColors6 = function() {
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

        @foreach($conteoEstados as $conteo)
        coloR6.push(dynamicColors6());
            @endforeach

        var ctx = document.getElementById("ChartFocusJob");
        var ctx1 = document.getElementById("ChartFocus");
        var ctx2 = document.getElementById("ChartJob");
        var ctx3 = document.getElementById("ChartStage");
        var ctx4 = document.getElementById("ChartIndicator");
        var ctx5 = document.getElementById("ChartArea");
        var ctx6 = document.getElementById("ChartStatus");

        var total = @json($total);
        var Operaciones = @json($dataOperaciones);
        var Administrativo = @json($dataAdministrativo);
        var Proyectos = @json($dataProyectos);
        var Iniciativas = @json($dataIniciativas);
        var numberWithCommas = function(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        };

        var lineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Calidad',
                    'Costos',
                    'Crecimiento',
                    'Gente',
                    'Servicio'
                ],
                datasets: [
                    {
                        label: 'Operaciones',
                        data: Operaciones,
                        backgroundColor: '#9be2ff',
                    },
                    {
                        label: 'Administrativo',
                        data: Administrativo,
                        backgroundColor: '#9cffa4',
                    },
                    {
                        label: 'Proyectos',
                        data: Proyectos,
                        backgroundColor: '#f2ffa4',
                    },
                    {
                        label: 'Iniciativas',
                        data: Iniciativas,
                        backgroundColor: '#ff9094',
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'right'
                },
                plugins: {
                    datalabels: {
                        color: '#3e3e3e',
                        font: {
                            weight: 'bold',
                            size: '14',
                        },
                        display: function (context) {
                            var index = context.dataIndex;
                            var value = context.dataset.data[index];
                            return value > 0; // display labels with a value greater than 0
                        }
                    }
                },
                animation: {
                    duration: 10,
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });

        var lineChart1 = new Chart(ctx1, {
            type: 'doughnut',
            plugins: [ChartDataLabels],
            data: {
                labels: [
                    @if ($peCalidad > 0)
                    'Calidad',
                    @endif
                    @if ($peCrecimiento > 0)
                    'Crecimiento',
                    @endif
                    @if ($peCosto > 0)
                    'Costo',
                    @endif
                    @if ($peGente > 0)
                    'Gente',
                    @endif
                    @if ($peServicio > 0)
                    'Servicio'
                    @endif
                ],
                datasets: [{
                    data:
                        [
                            @if ($peCalidad > 0)
                            {{$peCalidad}},
                            @endif
                            @if ($peCrecimiento > 0)
                            {{$peCrecimiento}},
                            @endif
                            @if ($peCosto > 0)
                            {{$peCosto}},
                            @endif
                            @if ($peGente > 0)
                            {{$peGente}},
                            @endif
                            @if ($peServicio > 0)
                            {{$peServicio}}
                            @endif
                        ],
                    backgroundColor: ['#33d0e9', '#71bb58', '#ff98f4', '#ff695d', '#a183ff'],
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
                            let percentage = (value*100 / total).toFixed(2)+"%";
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
                    @if ($ptOperaciones > 0)
                    'Operaciones',
                    @endif
                    @if ($ptAdministrativo > 0)
                    'Administrativo',
                    @endif
                        @if ($ptProyectos > 0)
                        'Proyectos',
                    @endif
                    @if ($ptIniciativas > 0)
                    'Iniciativas'
                    @endif
                ],
                datasets: [{
                    data:
                        [
                            @if ($ptOperaciones > 0)
                            {{$ptOperaciones}},
                            @endif
                            @if ($ptAdministrativo > 0)
                            {{$ptAdministrativo}},
                            @endif
                            @if ($ptProyectos > 0)
                            {{$ptProyectos}},
                            @endif
                            @if ($ptIniciativas > 0)
                            {{$ptIniciativas}}
                            @endif
                        ],
                    backgroundColor: ['#33d0e9', '#71bb58', '#ff98f4', '#ff695d'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    anchor: 'center',
                    align: 'center',
                    datalabels: {
                        formatter: (value, ctx2) => {
                            let sum = 0;
                            let dataArr = ctx2.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(2)+"%";
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
                    @foreach($fases as $fase)
                    "{{$fase}}",
                    @endforeach
                ],
                datasets: [{
                    data:
                        [
                            @foreach($conteofases as $conteo)
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
                        formatter: (value, ctx3) => {
                            let sum = 0;
                            let dataArr = ctx3.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(2)+"%";
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

        var lineChart4 = new Chart(ctx4, {
            type: 'doughnut',
            plugins: [ChartDataLabels],
            data: {
                labels: [
                    @foreach($indicadores as $indicador)
                        "{{$indicador}}",
                    @endforeach
                ],
                datasets: [{
                    data:
                        [
                            @foreach($conteoIndicadores as $conteo)
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
                        formatter: (value, ctx4) => {
                            let sum = 0;
                            let dataArr = ctx4.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(2)+"%";
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
                    },
                }
            }
        });

        var lineChart5 = new Chart(ctx5, {
            type: 'doughnut',
            plugins: [ChartDataLabels],
            data: {
                labels: [
                    @foreach($areas as $area)
                        "{{$area}}",
                    @endforeach
                ],
                datasets: [{
                    data:
                        [
                            @foreach($conteoAreas as $conteo)
                                "{{$conteo}}",
                            @endforeach
                        ],
                    backgroundColor: coloR5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        anchor: 'center',
                        align: 'center',
                        formatter: (value, ctx5) => {
                            let sum = 0;
                            let dataArr = ctx5.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(2)+"%";
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
                    },
                }
            }
        });

        var lineChart6 = new Chart(ctx6, {
            type: 'doughnut',
            plugins: [ChartDataLabels],
            data: {
                labels: [
                    @foreach($estados as $estado)
                        "{{$estado}}",
                    @endforeach
                ],
                datasets: [{
                    data:
                        [
                            @foreach($conteoEstados as $conteo)
                                "{{$conteo}}",
                            @endforeach
                        ],
                    backgroundColor: coloR6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        anchor: 'center',
                        align: 'center',
                        formatter: (value, ctx6) => {
                            let sum = 0;
                            let dataArr = ctx6.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(2)+"%";
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
                    },
                }
            }
        });
    </script>
@endsection
