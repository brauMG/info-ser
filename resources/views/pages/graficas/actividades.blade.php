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
                            <h4 class="no-bottom" style="text-transform: uppercase">Actividades Por Proyecto</h4>
                        </div>
                        <div class="card-body" style="background-color: rgba(176, 249, 255, 0.39) !important;">
                            <div class="container" style="text-align: right">
                                <i class="fas fa-project-diagram"></i> <strong>Total de Actividades:</strong> {{count($ActividadesProyecto)}}
                                <i class="fas fa-project-diagram"></i> <strong>Total de Proyectos:</strong> {{count($proyectos)}}
                            </div>
                            <div class="row bg-transparent rounded mb-0 column" style="background-color: white !important;">
                                <div class="col-xl-4 max" style="padding-top: 5%; padding-left: 2%">
                                    <div class="row row2 scroll-container">
                                        <table class="table-responsive table-card-inline custom-table">
                                            <thead class="thead"  style="text-align: left">
                                            <tr class="tr-card-complete">
                                                <th scope="col" class="th-card"><i class="far fa-check-square"></i> Actividad</th>
                                                <th scope="col" class="th-card"><i class="far fa-check-circle"></i> Proyecto</th>
                                            </tr>
                                            </thead>
                                            <tbody class="fonts" style="text-align: left">
                                            @foreach($ActividadesProyecto as $AP)
                                                <tr class="tr-card-complete">
                                                    <td class="td" style="padding-top: 1%"><i class="fas fa-check-square"></i> {{$AP->Actividad}}</td>
                                                    <td class="td" style="padding-top: 1%"><i class="fas fa-check-circle"></i> {{$AP->Proyecto}}</td>
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
                                                <canvas id="ActivitiesProject"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-see-results" style="border: solid; margin-bottom: 3% !important;">
                        <div class="card-header card-header-cute" style="background-color: #055e76 !important">
                            <h4 class="no-bottom" style="text-transform: uppercase">Actividades Por Estado</h4>
                        </div>
                        <div class="card-body" style="background-color: rgba(176, 249, 255, 0.39) !important;">
                            <div class="container" style="text-align: right">
                                <i class="fas fa-project-diagram"></i> <strong>Total de Actividades:</strong> {{count($ActividadesProyecto)}}
                                <i class="fas fa-project-diagram"></i> <strong>Total de Estados:</strong> 3
                            </div>
                            <div class="row bg-transparent rounded mb-0 column" style="background-color: white !important;">
                                <div class="col-xl-4 max" style="padding-top: 5%; padding-left: 2%">
                                    <div class="row row2 scroll-container">
                                        <table class="table-responsive table-card-inline custom-table">
                                            <thead class="thead"  style="text-align: left">
                                            <tr class="tr-card-complete">
                                                <th scope="col" class="th-card"><i class="far fa-check-square"></i> Actividad</th>
                                                <th scope="col" class="th-card"><i class="far fa-check-circle"></i> Estado</th>
                                            </tr>
                                            </thead>
                                            <tbody class="fonts" style="text-align: left">
                                            @foreach($ActividadesEstado as $AE)
                                                <tr class="tr-card-complete">
                                                    <td class="td" style="padding-top: 1%"><i class="fas fa-check-square"></i> {{$AE->Actividad}}</td>
                                                    @if($AE->Activo == 0)
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-question-circle"></i> Pendiente</td>
                                                    @elseif($AE->Activo == 1)
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-check-circle"></i> Aprobada</td>
                                                    @else
                                                        <td class="td" style="padding-top: 1%"><i class="fas fa-times-circle"></i> Desaprobada</td>
                                                    @endif
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
                                                <canvas id="ActivitiesStatus"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-see-results" style="border: solid; margin-bottom: 3% !important;">
                        <div class="card-header card-header-cute" style="background-color: #055e76 !important">
                            <h4 class="no-bottom" style="text-transform: uppercase">Actividades Por Usuario</h4>
                        </div>
                        <div class="card-body" style="background-color: rgba(176, 249, 255, 0.39) !important;">
                            <div class="container" style="text-align: right">
                                <i class="fas fa-project-diagram"></i> <strong>Total de Actividades:</strong> {{count($ActividadesProyecto)}}
                                <i class="fas fa-project-diagram"></i> <strong>Total de Usuarios:</strong> {{count($usuarios)}}
                            </div>
                            <div class="row bg-transparent rounded mb-0 column" style="background-color: white !important;">
                                <div class="col-xl-4 max" style="padding-top: 5%; padding-left: 2%">
                                    <div class="row row2 scroll-container">
                                        <table class="table-responsive table-card-inline custom-table">
                                            <thead class="thead"  style="text-align: left">
                                            <tr class="tr-card-complete">
                                                <th scope="col" class="th-card"><i class="far fa-check-square"></i> Actividad</th>
                                                <th scope="col" class="th-card"><i class="far fa-check-circle"></i> Usuario</th>
                                            </tr>
                                            </thead>
                                            <tbody class="fonts" style="text-align: left">
                                            @foreach($ActividadesUsuarios as $AU)
                                                <tr class="tr-card-complete">
                                                    <td class="td" style="padding-top: 1%"><i class="fas fa-check-square"></i> {{$AU->Actividad}}</td>
                                                    <td class="td" style="padding-top: 1%"><i class="fas fa-question-circle"></i> {{$AU->Usuario}}</td>
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
                                                <canvas id="ActivitiesUser"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-see-results" style="border: solid; margin-bottom: 3% !important;">
                        <div class="card-header card-header-cute" style="background-color: #055e76 !important">
                            <h4 class="no-bottom" style="text-transform: uppercase">Actividades Por Etapa</h4>
                        </div>
                        <div class="card-body" style="background-color: rgba(176, 249, 255, 0.39) !important;">
                            <div class="container" style="text-align: right">
                                <i class="fas fa-project-diagram"></i> <strong>Total de Actividades:</strong> {{count($ActividadesProyecto)}}
                                <i class="fas fa-project-diagram"></i> <strong>Total de Etapas:</strong> {{count($etapas)}}
                            </div>
                            <div class="row bg-transparent rounded mb-0 column" style="background-color: white !important;">
                                <div class="col-xl-4 max" style="padding-top: 5%; padding-left: 2%">
                                    <div class="row row2 scroll-container">
                                        <table class="table-responsive table-card-inline custom-table">
                                            <thead class="thead"  style="text-align: left">
                                            <tr class="tr-card-complete">
                                                <th scope="col" class="th-card"><i class="far fa-check-square"></i> Actividad</th>
                                                <th scope="col" class="th-card"><i class="far fa-check-circle"></i> Etapa</th>
                                            </tr>
                                            </thead>
                                            <tbody class="fonts" style="text-align: left">
                                            @foreach($ActividadesEtapas as $AE)
                                                <tr class="tr-card-complete">
                                                    <td class="td" style="padding-top: 1%"><i class="fas fa-check-square"></i> {{$AE->Actividad}}</td>
                                                    <td class="td" style="padding-top: 1%"><i class="fas fa-question-circle"></i> {{$AE->Etapa}}</td>
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
                                                <canvas id="ActivitiesUStage"></canvas>
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
        var ctx = document.getElementById("ActivitiesProject");
        var ctx1 = document.getElementById("ActivitiesStatus");
        var ctx2 = document.getElementById("ActivitiesUser");
        var ctx3 = document.getElementById("ActivitiesUStage");
        var total = @json($total);

        var lineChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    @foreach($proyectos as $proyecto)
                        "{{$proyecto}}",
                    @endforeach
                ],
                datasets: [{
                    data:
                        [
                            @foreach($conteoProyectos as $conteo)
                                "{{$conteo}}",
                            @endforeach
                        ],
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'right'
                },
                plugins: {
                    colorschemes: {
                        scheme: 'office.BlueGreen6'
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = 0;
                            let dataArr = ctx.chart.data.datasets[0].data;
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

        var lineChart1 = new Chart(ctx1, {
            type: 'pie',
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
                }]
            },
            options: {
                responsive: true,
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
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'right'
                },
                plugins: {
                    colorschemes: {
                        scheme: 'office.BlueGreen6'
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = 0;
                            let dataArr = ctx.chart.data.datasets[0].data;
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
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'right'
                },
                plugins: {
                    colorschemes: {
                        scheme: 'office.BlueGreen6'
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = 0;
                            let dataArr = ctx.chart.data.datasets[0].data;
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

