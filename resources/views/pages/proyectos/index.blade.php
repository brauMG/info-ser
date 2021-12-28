@extends('layouts.app', ['activePage' => 'Proyectos', 'titlePage' => __('Proyectos')])

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
                                    <h4 class="card-title ">Lista de Proyectos</h4>
                                    <p class="card-category">Estos son los proyectos registrados en el sistema</p>
                                    @if($rol == 4 || $rol == 7)
                                    <button type="button" class="btn btn-info" id="new" onclick="AddProyecto();">Agregar Proyecto <i class="material-icons">add_circle_outline</i></button>
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
                                <table class="table table-striped table-bordered data-table" style="table-layout: auto">
                                    <thead class="text-primary thead-color">
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">ID</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Nombre</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Objetivo</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Criterio de Exito</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Estado</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Registro de Actividades</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Fase</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Etapas</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Roles</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Enfoque</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Trabajo</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Indicador</th>
                                    @if($rol == 4 || $rol == 3 || $rol == 7)
                                        <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Gerencia</th>
                                    @endif
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Área</th>

                                    </thead>
                                    <tbody>
                                    @foreach ($proyecto as $item)
                                        <tr>
                                        @if($item->activo == 1)
                                                <td>{{$item->id}}<i class="material-icons plus">add_circle</i></td>
                                                <td>{{$item->proyecto}}</td>
                                                <td>{{$item->objetivo}}</td>
                                                <td>{{$item->criterio}}</td>
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-sm btn-warning" @if($rol == 4 || $rol == 7) clave="{{$item->id}}" onclick="changeEstado(this);" @endif style="cursor: pointer"><i class="material-icons">edit</i> {{$item->estado}}</button>
                                                </td>
                                                <td style="text-align: center">
                                                    <a class="btn btn-sm btn-secondary" href="{{route('TypeActivity', $item->id)}}"><i class="material-icons">edit</i> Registrar Actividad</a>
                                                </td>
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-sm btn-success" @if($rol == 4 || $rol == 7) clave="{{$item->id}}" onclick="changeFase(this);" @endif style="cursor: pointer"><i class="material-icons">edit</i> {{$item->fase}}</button>
                                                </td>
                                                @if($rol == 4 || $rol == 3 || $rol == 7)
                                                    <td style="text-align: center">
                                                        <button type="button" class="btn btn-sm btn-warning" clave="{{$item->id}}" onclick="seeEtapas(this);" style="cursor: pointer"><i class="material-icons">edit</i> ver etapas</button>
                                                    </td>
                                                @endif
                                                @if($rol == 4 || $rol == 3 || $rol == 7)
                                                    <td style="text-align: center">
                                                        <button type="button" class="btn btn-sm btn-warning" clave="{{$item->id}}" onclick="seeRole(this);" style="cursor: pointer"><i class="material-icons">edit</i> ver roles</button>
                                                    </td>
                                                @endif
                                                <td>{{$item->enfoque}}</td>
                                                <td>{{$item->trabajo}}</td>
                                                <td>{{$item->indicador}}</td>
                                                @if($rol == 4 || $rol == 3 || $rol == 7)
                                                    <td>{{$item->gerencia}}</td>
                                                @endif
                                                <td>{{$item->area}}</td>
                                        @elseif($item->activo == 0)
                                            <td>{{$item->id}}<i class="material-icons plus">add_circle</i></td>
                                            <td>{{$item->proyecto}}</td>
                                            <td>{{$item->objetivo}}</td>
                                            <td>{{$item->criterio}}</td>
                                                @if($item->estado == 'Completado' || $item->estado == 'Terminado' || $item->estado == 'Finalizado' || $item->estado == 'Acabado' || $item->estado == 'Hecho')
                                                    <td style="text-align: center">
                                                        <button type="button" class="btn btn-sm btn-success" @if($rol == 4 || $rol == 7) clave="{{$item->id}}" onclick="changeEstado(this);" @endif data-toggle="tooltip" data-placement="top" title="Este estado bloquea el proyecto"><i class="material-icons">edit</i> {{$item->estado}}</button>
                                                    </td>
                                                @else
                                                    <td style="text-align: center">
                                                        <button type="button" class="btn btn-sm btn-warning" @if($rol == 4 || $rol == 7) clave="{{$item->id}}" onclick="changeEstado(this);" @endif data-toggle="tooltip" data-placement="top" title="Este estado bloquea el proyecto"><i class="material-icons">edit</i> {{$item->estado}}</button>
                                                    </td>
                                                @endif
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-sm btn-dark text-white" data-toggle="tooltip" data-placement="top" title="Debido al estado del proyecto, no es posible registrar actividades"><i class="material-icons">edit</i> Registrar Actividad</button>
                                                </td>
                                            <td style="text-align: center">
                                                <button type="button" class="btn btn-sm btn-dark text-white" data-toggle="tooltip" data-placement="top" title="Debido al estado del proyecto, no se puede cambiar de fase" style="cursor: not-allowed"><i class="material-icons">edit</i> {{$item->fase}}</button>
                                            </td>
                                                @if($rol == 4 || $rol == 3 || $rol == 7)
                                                    <td style="text-align: center">
                                                        <button type="button" class="btn btn-sm btn-dark text-white" data-toggle="tooltip" data-placement="top" title="Debido al estado del proyecto, no se pueden ver sus etapas" clave="{{$item->id}}" onclick="seeEtapas(this);" style="cursor: not-allowed"><i class="material-icons">edit</i> ver etapas</button>
                                                    </td>
                                                @endif
                                                @if($rol == 4 || $rol == 3 || $rol == 7)
                                                    <td style="text-align: center">
                                                        <button type="button" class="btn btn-sm btn-dark text-white" data-toggle="tooltip" data-placement="top" title="Debido al estado del proyecto, no se pueden ver sus roles" clave="{{$item->id}}" onclick="seeRole(this);" style="cursor: not-allowed"><i class="material-icons">edit</i> ver roles</button>
                                                    </td>
                                                @endif
                                                <td>{{$item->enfoque}}</td>
                                            <td>{{$item->trabajo}}</td>
                                            <td>{{$item->indicador}}</td>
                                                @if($rol == 4 || $rol == 3 || $rol == 7)
                                                    <td>{{$item->gerencia}}</td>
                                                @endif
                                                <td>{{$item->area}}</td>
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
        });

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

        function AddProyecto() {
            $('#myModal').load('{{ url('/proyectos/new') }}', function (response, status, xhr) {
                if (status === "success")
                    $('#myModal').modal('show');
            });
        }

        function changeEstado(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/proyectos/ChangeStatus') }}/'+clave,function(response, status, xhr){
                if ( status === "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function changeFase(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/proyectos/ChangeStage') }}/'+clave,function(response, status, xhr){
                if ( status === "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function seeEtapas(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/etapas/get/') }}/'+clave,function(response, status, xhr){
                if ( status === "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function seeRole(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/roles-proyectos/get/') }}/'+clave,function(response, status, xhr){
                if ( status === "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function add(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/actividades/new') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
            }

    </script>
@endsection
