@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
        <div class="container adjust">
            <div data-simplebar class="card-height-add-test" style="height: 980px !important;">
                <div class="col text-center">
                    <div class="justify-content-center">

                        <div class="card card-see-results" style="border: solid; margin-bottom: 3% !important;">
                            <div class="card-header card-header-cute" style="background-color: #055e76 !important">
                                <h4 class="no-bottom" style="text-transform: uppercase">actividades de trabajo Por Enfoque y tipo de Trabajo</h4>
                            </div>
                            <div class="card-body" style="background-color: rgba(176, 249, 255, 0.39) !important;">
                                <div class="container" style="text-align: right">
                                    <i class="fas fa-project-diagram"></i> <strong>Total de Proyectos:</strong> {{count($ProyectosEnfoque)}}
                                </div>
                                <div class="row bg-transparent rounded mb-0 column" style="background-color: white !important;">
                                    <div class="col-xl-4 max" style="padding-top: 5%; padding-left: 2%">
                                        <div class="row row2 scroll-container">
                                            <table class="table-responsive table-card-inline custom-table-3">
                                                <thead class="thead"  style="text-align: left">
                                                <tr class="tr-card-complete">
                                                    <th scope="col" class="th-card"><i class="far fa-check-square"></i> Proyecto</th>
                                                    <th scope="col" class="th-card"><i class="far fa-check-circle"></i> Trabajo</th>
                                                    <th scope="col" class="th-card"><i class="far fa-check-circle"></i> Enfoque</th>
                                                </tr>
                                                </thead>
                                                <tbody class="fonts" style="text-align: left">
                                                @foreach($ProyectosTrabajoEnfoque as $PTE)
                                                    <tr class="tr-card-complete">
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-square"></i> {{$PTE->Proyecto}}</td>
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-circle"></i> {{$PTE->Trabajo}}</td>
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-circle"></i> {{$PTE->Enfoque}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row2 col-xl-8 max my-auto ">
                                        <div class="card bg-transparent" style="border: none; ">
                                            <div class="card-body">
                                                <div class="chart">
                                                    <canvas id="ChartFocusJob"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-see-results" style="border: solid; margin-bottom: 3% !important;">
                            <div class="card-header card-header-cute" style="background-color: #055e76 !important">
                                <h4 class="no-bottom" style="text-transform: uppercase">actividades de trabajo Por Enfoque</h4>
                            </div>
                            <div class="card-body" style="background-color: rgba(176, 249, 255, 0.39) !important;">
                                <div class="container" style="text-align: right">
                                    <i class="fas fa-project-diagram"></i> <strong>Total de Proyectos:</strong> {{count($ProyectosEnfoque)}}
                                    <br>
                                    <i class="fas fa-tasks"></i> <strong>Total de Enfoques:</strong> 5
                                    <br>
                                </div>
                                <div class="row bg-transparent rounded mb-0 column" style="background-color: white !important;">
                                    <div class="col-xl-4 max" style="padding-top: 5%; padding-left: 2%">
                                        <div class="row row2 scroll-container">
                                            <table class="table-responsive table-card-inline custom-table">
                                                <thead class="thead"  style="text-align: left">
                                                <tr class="tr-card-complete">
                                                    <th scope="col" class="th-card"><i class="far fa-check-square"></i> Proyecto</th>
                                                    <th scope="col" class="th-card"><i class="far fa-check-circle"></i> Enfoque</th>
                                                </tr>
                                                </thead>
                                                <tbody class="fonts" style="text-align: left">
                                                @foreach($ProyectosEnfoque as $PE)
                                                        <tr class="tr-card-complete">
                                                            <td class="td" style="padding-top: 1%"><i class="fas fa-check-square"></i> {{$PE->Proyecto}}</td>
                                                            <td class="td" style="padding-top: 1%"><i class="fas fa-check-circle"></i> {{$PE->Enfoque}}</td>
                                                        </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row2 col-xl-8 max my-auto ">
                                        <div class="card bg-transparent" style="border: none; ">
                                            <div class="card-body">
                                                <div class="chart">
                                                    <canvas id="ChartFocus"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-see-results" style="border: solid; margin-bottom: 3% !important;">
                            <div class="card-header card-header-cute" style="background-color: #055e76 !important">
                                <h4 class="no-bottom" style="text-transform: uppercase">actividades de trabajo Por tipo de Trabajo</h4>
                            </div>
                            <div class="card-body" style="background-color: rgba(176, 249, 255, 0.39) !important;">
                                <div class="container" style="text-align: right">
                                    <i class="fas fa-project-diagram"></i> <strong>Total de Proyectos:</strong> {{count($ProyectosEnfoque)}}
                                    <br>
                                    <i class="fas fa-tasks"></i> <strong>Total de Trabajos:</strong> 4
                                    <br>
                                </div>
                                <div class="row bg-transparent rounded mb-0 column" style="background-color: white !important;">
                                    <div class="col-xl-4 max" style="padding-top: 5%; padding-left: 2%">
                                        <div class="row row2 scroll-container">
                                            <table class="table-responsive table-card-inline custom-table">
                                                <thead class="thead"  style="text-align: left">
                                                <tr class="tr-card-complete">
                                                    <th scope="col" class="th-card"><i class="far fa-check-square"></i> Proyecto</th>
                                                    <th scope="col" class="th-card"><i class="far fa-check-circle"></i> Trabajo</th>
                                                </tr>
                                                </thead>
                                                <tbody class="fonts" style="text-align: left">
                                                @foreach($ProyectosTrabajo as $PT)
                                                    <tr class="tr-card-complete">
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-square"></i> {{$PT->Proyecto}}</td>
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-circle"></i> {{$PT->Trabajo}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row2 col-xl-8 max my-auto ">
                                        <div class="card bg-transparent" style="border: none; ">
                                            <div class="card-body">
                                                <div class="chart">
                                                    <canvas id="ChartJob"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-see-results" style="border: solid; margin-bottom: 3% !important;">
                            <div class="card-header card-header-cute" style="background-color: #055e76 !important">
                                <h4 class="no-bottom" style="text-transform: uppercase">actividades de trabajo Por Fase</h4>
                            </div>
                            <div class="card-body" style="background-color: rgba(176, 249, 255, 0.39) !important;">
                                <div class="container" style="text-align: right">
                                    <i class="fas fa-project-diagram"></i> <strong>Total de Proyectos:</strong> {{count($ProyectosEnfoque)}}
                                    <br>
                                    <i class="fas fa-tasks"></i> <strong>Total de Fases:</strong> {{count($fases)}}
                                    <br>
                                </div>
                                <div class="row bg-transparent rounded mb-0 column" style="background-color: white !important;">
                                    <div class="col-xl-4 max" style="padding-top: 5%; padding-left: 2%">
                                        <div class="row row2 scroll-container">
                                            <table class="table-responsive table-card-inline custom-table">
                                                <thead class="thead"  style="text-align: left">
                                                <tr class="tr-card-complete">
                                                    <th scope="col" class="th-card"><i class="far fa-check-square"></i> Proyecto</th>
                                                    <th scope="col" class="th-card"><i class="far fa-check-circle"></i> Fase</th>
                                                </tr>
                                                </thead>
                                                <tbody class="fonts" style="text-align: left">
                                                @foreach($ProyectosFase as $PF)
                                                    <tr class="tr-card-complete">
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-square"></i> {{$PF->Proyecto}}</td>
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-circle"></i> {{$PF->Fase}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row2 col-xl-8 max my-auto ">
                                        <div class="card bg-transparent" style="border: none; ">
                                            <div class="card-body">
                                                <div class="chart">
                                                    <canvas id="ChartStage"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-see-results" style="border: solid; margin-bottom: 3% !important;">
                            <div class="card-header card-header-cute" style="background-color: #055e76 !important">
                                <h4 class="no-bottom" style="text-transform: uppercase">actividades de trabajo Por Indicador</h4>
                            </div>
                            <div class="card-body" style="background-color: rgba(176, 249, 255, 0.39) !important;">
                                <div class="container" style="text-align: right">
                                    <i class="fas fa-project-diagram"></i> <strong>Total de Proyectos:</strong> {{count($ProyectosEnfoque)}}
                                    <br>
                                    <i class="fas fa-tasks"></i> <strong>Total de Indicadores:</strong> {{count($indicadores)}}
                                    <br>
                                </div>
                                <div class="row bg-transparent rounded mb-0 column" style="background-color: white !important;">
                                    <div class="col-xl-4 max" style="padding-top: 5%; padding-left: 2%">
                                        <div class="row row2 scroll-container">
                                            <table class="table-responsive table-card-inline custom-table">
                                                <thead class="thead"  style="text-align: left">
                                                <tr class="tr-card-complete">
                                                    <th scope="col" class="th-card"><i class="far fa-check-square"></i> Proyecto</th>
                                                    <th scope="col" class="th-card"><i class="far fa-check-circle"></i> Indicador</th>
                                                </tr>
                                                </thead>
                                                <tbody class="fonts" style="text-align: left">
                                                @foreach($ProyectosIndicador as $PI)
                                                    <tr class="tr-card-complete">
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-square"></i> {{$PI->Proyecto}}</td>
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-circle"></i> {{$PI->Indicador}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row2 col-xl-8 max my-auto ">
                                        <div class="card bg-transparent" style="border: none; ">
                                            <div class="card-body">
                                                <div class="chart">
                                                    <canvas id="ChartIndicator"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-see-results" style="border: solid; margin-bottom: 3% !important;">
                            <div class="card-header card-header-cute" style="background-color: #055e76 !important">
                                <h4 class="no-bottom" style="text-transform: uppercase">actividades de trabajo Por Área</h4>
                            </div>
                            <div class="card-body" style="background-color: rgba(176, 249, 255, 0.39) !important;">
                                <div class="container" style="text-align: right">
                                    <i class="fas fa-project-diagram"></i> <strong>Total de Proyectos:</strong> {{count($ProyectosEnfoque)}}
                                    <br>
                                    <i class="fas fa-tasks"></i> <strong>Total de Áreas:</strong> {{count($areas)}}
                                    <br>
                                </div>
                                <div class="row bg-transparent rounded mb-0 column" style="background-color: white !important;">
                                    <div class="col-xl-4 max" style="padding-top: 5%; padding-left: 2%">
                                        <div class="row row2 scroll-container">
                                            <table class="table-responsive table-card-inline custom-table">
                                                <thead class="thead"  style="text-align: left">
                                                <tr class="tr-card-complete">
                                                    <th scope="col" class="th-card"><i class="far fa-check-square"></i> Proyecto</th>
                                                    <th scope="col" class="th-card"><i class="far fa-check-circle"></i> Área</th>
                                                </tr>
                                                </thead>
                                                <tbody class="fonts" style="text-align: left">
                                                @foreach($ProyectosArea as $PA)
                                                    <tr class="tr-card-complete">
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-square"></i> {{$PA->Proyecto}}</td>
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-circle"></i> {{$PA->Area}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row2 col-xl-8 max my-auto ">
                                        <div class="card bg-transparent" style="border: none; ">
                                            <div class="card-body">
                                                <div class="chart">
                                                    <canvas id="ChartArea"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-see-results" style="border: solid; margin-bottom: 3% !important;">
                            <div class="card-header card-header-cute" style="background-color: #055e76 !important">
                                <h4 class="no-bottom" style="text-transform: uppercase">actividades de trabajo Por Estado</h4>
                            </div>
                            <div class="card-body" style="background-color: rgba(176, 249, 255, 0.39) !important;">
                                <div class="container" style="text-align: right">
                                    <i class="fas fa-project-diagram"></i> <strong>Total de Proyectos:</strong> {{count($ProyectosEnfoque)}}
                                    <br>
                                    <i class="fas fa-tasks"></i> <strong>Total de Estados:</strong> {{count($estados)}}
                                    <br>
                                </div>
                                <div class="row bg-transparent rounded mb-0 column" style="background-color: white !important;">
                                    <div class="col-xl-4 max" style="padding-top: 5%; padding-left: 2%">
                                        <div class="row row2 scroll-container">
                                            <table class="table-responsive table-card-inline custom-table">
                                                <thead class="thead"  style="text-align: left">
                                                <tr class="tr-card-complete">
                                                    <th scope="col" class="th-card"><i class="far fa-check-square"></i> Proyecto</th>
                                                    <th scope="col" class="th-card"><i class="far fa-check-circle"></i> Estado</th>
                                                </tr>
                                                </thead>
                                                <tbody class="fonts" style="text-align: left">
                                                @foreach($ProyectosEstado as $PE)
                                                    <tr class="tr-card-complete">
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-square"></i> {{$PE->Proyecto}}</td>
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-circle"></i> {{$PE->Estado}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row2 col-xl-8 max my-auto ">
                                        <div class="card bg-transparent" style="border: none; ">
                                            <div class="card-body">
                                                <div class="chart">
                                                    <canvas id="ChartStatus"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>

    <script>
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
            type: 'horizontalBar',
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
                    },
                    {
                        label: 'Administrativo',
                        data: Administrativo,
                    },
                    {
                        label: 'Proyectos',
                        data: Proyectos,
                    },
                    {
                        label: 'Iniciativas',
                        data: Iniciativas,
                    }
                ]
            },
            options: {
                responsive: true,
                aspectRatio: false,
                legend: {
                    position: 'right'
                },
                plugins: {
                    colorschemes: {
                        scheme: 'office.BlueGreen6'
                    },
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
                    xAxes: [{
                        stacked: true,
                        gridLines: { display: false },
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            callback: function(value) { return numberWithCommas(value); },
                        },
                    }],
                }
            }
        });

        var lineChart1 = new Chart(ctx1, {
            type: 'pie',
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
                }]
            },
            options: {
                responsive: true,
                aspectRatio: false,
                legend: {
                    position: 'right'
                },
                plugins: {
                    colorschemes: {
                        scheme: 'office.BlueGreen6'
                    },
                    datalabels: {
                        formatter: (value, ctx1) => {
                            let sum = 0;
                            let dataArr = ctx1.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(2)+"%";
                            return percentage;
                        },
                        color: '#3e3e3e',
                        font: {
                            weight: 'bold',
                            size: '14',
                        },
                    }
                }
            }
        });

        var lineChart2 = new Chart(ctx2, {
            type: 'pie',
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
                }]
            },
            options: {
                responsive: true,
                aspectRatio: false,
                legend: {
                    position: 'right'
                },
                plugins: {
                    colorschemes: {
                        scheme: 'office.BlueGreen6'
                    },
                    datalabels: {
                        formatter: (value, ctx2) => {
                            let sum = 0;
                            let dataArr = ctx2.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(2)+"%";
                            return percentage;
                        },
                        color: '#3e3e3e',
                        font: {
                            weight: 'bold',
                            size: '14',
                        },
                    }
                }
            }
        });

        var lineChart3 = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: [
                    @foreach($fases as $fase)
                    "{{$fase}}",
                    @endforeach
                ],
                datasets: [{
                    data:
                        [
                            @foreach($conteoFases as $conteo)
                                "{{$conteo}}",
                            @endforeach
                        ],
                }]
            },
            options: {
                responsive: true,
                aspectRatio: false,
                legend: {
                    position: 'right'
                },
                plugins: {
                    colorschemes: {
                        scheme: 'office.BlueGreen6'
                    },
                    datalabels: {
                        formatter: (value, ctx3) => {
                            let sum = 0;
                            let dataArr = ctx3.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(2)+"%";
                            return percentage;
                        },
                        color: '#3e3e3e',
                        font: {
                            weight: 'bold',
                            size: '14',
                        },
                    }
                }
            }
        });

        var lineChart4 = new Chart(ctx4, {
            type: 'pie',
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
                }]
            },
            options: {
                responsive: true,
                aspectRatio: false,
                legend: {
                    position: 'right'
                },
                plugins: {
                    colorschemes: {
                        scheme: 'office.BlueGreen6'
                    },
                    datalabels: {
                        formatter: (value, ctx4) => {
                            let sum = 0;
                            let dataArr = ctx4.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(2)+"%";
                            return percentage;
                        },
                        color: '#3e3e3e',
                        font: {
                            weight: 'bold',
                            size: '14',
                        },
                    }
                }
            }
        });

        var lineChart5 = new Chart(ctx5, {
            type: 'pie',
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
                }]
            },
            options: {
                responsive: true,
                aspectRatio: false,
                legend: {
                    position: 'right'
                },
                plugins: {
                    colorschemes: {
                        scheme: 'office.BlueGreen6'
                    },
                    datalabels: {
                        formatter: (value, ctx5) => {
                            let sum = 0;
                            let dataArr = ctx5.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(2)+"%";
                            return percentage;
                        },
                        color: '#3e3e3e',
                        font: {
                            weight: 'bold',
                            size: '14',
                        },
                    }
                }
            }
        });

        var lineChart6 = new Chart(ctx6, {
            type: 'pie',
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
                }]
            },
            options: {
                responsive: true,
                aspectRatio: false,
                legend: {
                    position: 'right'
                },
                plugins: {
                    colorschemes: {
                        scheme: 'office.BlueGreen6'
                    },
                    datalabels: {
                        formatter: (value, ctx6) => {
                            let sum = 0;
                            let dataArr = ctx6.chart.data.datasets[0].data;
                            let percentage = (value*100 / total).toFixed(2)+"%";
                            return percentage;
                        },
                        color: '#3e3e3e',
                        font: {
                            weight: 'bold',
                            size: '14',
                        },
                    }
                }
            }
        });
    </script>
@endsection
