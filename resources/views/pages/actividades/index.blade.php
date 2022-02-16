@extends('layouts.app', ['activePage' => 'Actividades', 'titlePage' => __('Actividades')])

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
                                <div class="col-md-8">
                                    <h4 class="card-title ">Actividades</h4>
                                    <p class="card-category">Esta es la lista de actividades registradas en el sistema</p>
                                    @if($rol == 4 || $rol == 3)
                                    <a href="{{url('/proyectos')}}" class="btn btn-info" id="new">Agregar Actividad <i class="material-icons">add_circle_outline</i></a>
                                    @endif
                                </div>
                                @if($rol == 4 || $rol == 7)
                                    <div class="col-md-4">
                                        <div class="form-group" style="float: right">
                                            <label class="text-white">Filtrar Gerencia</label>
                                            <select id="gerencia-filter" class="custom-select">
                                                <option value="">Todas</option>
                                                @foreach($gerencias as $gerencia)
                                                    <option>{{$gerencia->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered data-table">
                                    <thead class="text-primary thead-color">
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">ID</th>
                                    @if($rol == 4 || $rol == 3 || $rol == 7 || $rol == 6)
                                        <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Gerencia</th>
                                    @endif
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Proyecto</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Fase</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Etapa</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Usuario</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">¿Qué se hizo?</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Pendiente por Hacer</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Evidencia</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Fecha de Creación</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Estado de Revisión</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Fecha de Revisión</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Hora de Revisión</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Fecha de Vencimiento</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Hora de Vencimiento</th>
                                    @if($rol == 4 || $rol == 7)
                                        <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Acciones</th>
                                    @endif
                                    </thead>
                                    <tbody>
                                    @foreach ($actividad as $item)
                                        <tr>
                                        <td>{{$item->id}}<i class="material-icons plus">add_circle</i></td>
                                            @if($rol == 4 || $rol == 3 || $rol == 7 || $rol == 6)
                                                <td>{{$item->gerencia}}</td>
                                            @endif
                                        <td>{{$item->proyecto}}</td>
                                        <td>{{$item->fase}}</td>
                                        <td>{{$item->etapa}}</td>
                                        <td>{{$item->usuario}}</td>
                                        <td>{{$item->descripcion}}</td>
                                            <td>{{$item->decision}}</td>
                                            @if(isset($item->evidence) == null)
                                                <td class="action-row" style="text-align: center">
                                                    <a class="btn btn-sm btn-dark text-white" disabled="true">Sin Evidencia</a>
                                                </td>
                                            @else
                                                <td class="action-row" style="text-align: center">
                                                    <a class="btn btn-sm btn-info text-white" href="{{('/evidence/'.$item->evidence)}}" target="_blank"><i class="material-icons">visibility</i> Ver</a>
                                                </td>
                                            @endif
                                        <td style="text-align: center">
                                            <a class="btn btn-sm btn-dark text-white"><i class="material-icons">event_available</i>{{$item->fecha_creacion}}</a>
                                        </td>
                                        @if($item->estado == 0)
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-warning text-white" @if($rol == 4) clave="{{$item->id}}" onclick="changeEstado(this);" @endif><i class="material-icons">help</i> Pendiente</a>
                                            </td>
                                        @elseif($item->estado == 1)
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-success text-white" @if($rol == 4) clave="{{$item->id}}" onclick="changeEstado(this);" @endif data-toggle="tooltip" data-placement="top" title="Esta actividad ya fue revisada"><i class="material-icons">check_circle</i> Aprobada</a>
                                            </td>
                                        @elseif($item->estado == 2)
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-danger text-white" @if($rol == 4) clave="{{$item->id}}" onclick="changeEstado(this);" @endif data-toggle="tooltip" data-placement="top" title="Esta actividad ya fue revisada"><i class="material-icons">dangerous</i> Desaprobada</a>
                                            </td>
                                        @endif
                                        @if($item->fecha_revision == null)
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-warning text-white"><i class="material-icons">help</i> Pendiente</a>
                                            </td>
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-warning text-white"><i class="material-icons">help</i> Pendiente</a>
                                            </td>
                                        @elseif($item->fecha_revision > $item->fecha_vencimiento)
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-danger text-white"><i class="material-icons">event_available</i> Se reviso tarde el: {{$item->fecha_revision}}</a>
                                            </td>
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-danger text-white"><i class="material-icons">timer</i> Se reviso a las: {{$item->hora_revision}}</a>
                                            </td>
                                        @elseif($item->fecha_revision <= $item->fecha_vencimiento)
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-success text-white"><i class="material-icons">event_available</i> Se reviso a tiempo el: {{$item->fecha_revision}}</a>
                                            </td>
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-success text-white"><i class="material-icons">timer</i> Se reviso a las: {{$item->hora_revision}}</a>
                                            </td>
                                        @endif
                                        @if($date == $item->fecha_vencimiento)
                                            @if($time > $item->hora_vencimiento)
                                                <td style="text-align: center">
                                                    <a class="btn btn-sm btn-danger text-white"><i class="material-icons">event_busy</i> Vencio hoy: {{$item->fecha_vencimiento}}</a>
                                                </td>
                                                <td style="text-align: center">
                                                    <a class="btn btn-sm btn-danger text-white"><i class="material-icons">hourglass_bottom</i> Vencio hoy a las: {{$item->hora_vencimiento}}</a>
                                                </td>
                                            @else
                                                <td style="text-align: center">
                                                    <a class="btn btn-sm btn-warning text-white"><i class="material-icons">event</i> Vence hoy: {{$item->fecha_vencimiento}}</a>
                                                </td>
                                                <td style="text-align: center">
                                                    <a class="btn btn-sm btn-warning text-white"><i class="material-icons">hourglass_top</i> Vence hoy a las: {{$item->hora_vencimiento}}</a>
                                                </td>
                                            @endif
                                        @elseif($date < $item->fecha_vencimiento)
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-success text-white"><i class="material-icons">event</i> Vence el: {{$item->fecha_vencimiento}}</a>
                                            </td>
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-success text-white"><i class="material-icons">hourglass_top</i> Vence a las: {{$item->hora_vencimiento}}</a>
                                            </td>
                                        @else
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-danger text-white"><i class="material-icons">event_available</i> Vencio el: {{$item->fecha_vencimiento}}</a>
                                            </td>
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-danger text-white"><i class="material-icons">hourglass_bottom</i> Vencio a las: {{$item->hora_vencimiento}}</a>
                                            </td>
                                        @endif
                                            @if($rol === 4 || $rol === 7)
                                                <td class="action-row" style="font-size: 12px">
                                                    <button clave="{{$item->id}}" onclick="editActivity(this);" type="button" rel="tooltip" class="btn btn-sm btn-warning btn-adjust">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        if(window.innerWidth > 500) {
        var table = $('.data-table').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 Filas', '25 Filas', '50 Filas', 'Mostrar todo']
                ],
                dom: 'Blfrtip',
                buttons: [
                    { extend: 'pdf', text: 'Exportar a PDF',charset: 'UTF-8' },
                    { extend: 'csv', text: 'Exportar a EXCEL',charset: 'UTF-8'  }
                ],
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad",
                        "print": "Imprimir",
                        "csv": "Excel"
                    }
                },
            }
        );
        } else {
            var table = $('.data-table').DataTable({
                    responsive: true,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        ['10 Filas', '25 Filas', '50 Filas', 'Mostrar todo']
                    ],
                    dom: 'Blfrtip',
                    buttons: [
                        { extend: 'pdf', text: 'Exportar a PDF',charset: 'UTF-8' },
                        { extend: 'csv', text: 'Exportar a EXCEL',charset: 'UTF-8'  }
                    ],
                    language: {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        },
                        "buttons": {
                            "copy": "Copiar",
                            "colvis": "Visibilidad",
                            "print": "Imprimir",
                            "csv": "Excel"
                        }
                    },
                }
            );
        }

        $('#gerencia-filter').on('change', function(){
            table.search(this.value).draw();
        });

        $('.mydatatable').DataTable();

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $('.mydatatable').DataTable();

        function changeEstado(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/actividades/ChangeStatus') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function editActivity(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/actividades/sub_edit') }}/'+clave,function(response, status, xhr){
                if ( status === "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }
    </script>
@endsection
