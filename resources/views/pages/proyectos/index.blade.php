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
                            <h4 class="card-title ">Lista de Proyectos</h4>
                            <p class="card-category">Estos son los proyectos registrados en el sistema</p>
                            @if($rol == 4)
                            <button type="button" class="btn btn-info" id="new" onclick="AddProyecto();">Agregar Proyecto <i class="material-icons">add_circle_outline</i></button>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered data-table">
                                    <thead class="text-primary thead-color">
                                    <th>ID<i class="material-icons sort">sort</i></th>
                                    <th>Descripción<i class="material-icons sort">sort</i></th>
                                    <th>Objetivo<i class="material-icons sort">sort</i></th>
                                    <th>Criterio de Exito<i class="material-icons sort">sort</i></th>
                                    <th>Área<i class="material-icons sort">sort</i></th>
                                    <th>Fase<i class="material-icons sort">sort</i></th>
                                    <th>Enfoque<i class="material-icons sort">sort</i></th>
                                    <th>Trabajo<i class="material-icons sort">sort</i></th>
                                    <th>Indicador<i class="material-icons sort">sort</i></th>
                                    <th>Estado<i class="material-icons sort">sort</i></th>
                                    <th>Registro<i class="material-icons sort">sort</i></th>
                                    </thead>
                                    <tbody>
                                    @foreach ($proyecto as $item)
                                        <tr>
                                        @if($item->activo == 1)
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->proyecto}}</td>
                                            <td>{{$item->objetivo}}</td>
                                            <td>{{$item->criterio}}</td>
                                            <td>{{$item->area}}</td>
                                            <td style="text-align: center">
                                                <button type="button" class="btn btn-sm btn-success" @if($rol == 4) clave="{{$item->id}}" onclick="changeFase(this);" @endif style="cursor: pointer"><i class="material-icons">edit</i> {{$item->fase}}</button>
                                            </td>
                                            <td>{{$item->enfoque}}</td>
                                            <td>{{$item->trabajo}}</td>
                                            <td>{{$item->indicador}}</td>
                                            <td style="text-align: center">
                                                <button type="button" class="btn btn-sm btn-warning" @if($rol == 4) clave="{{$item->id}}" onclick="changeEstado(this);" @endif style="cursor: pointer"><i class="material-icons">edit</i> {{$item->estado}}</button>
                                            </td>
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-secondary" href="{{route('TypeActivity', $item->id)}}"><i class="material-icons">edit</i> Registrar Actividad</a>
                                            </td>
                                        @elseif($item->activo == 0)
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->proyecto}}</td>
                                            <td>{{$item->objetivo}}</td>
                                            <td>{{$item->criterio}}</td>
                                            <td>{{$item->area}}</td>
                                            <td style="text-align: center">
                                                <button type="button" class="btn btn-sm btn-dark text-white" data-toggle="tooltip" data-placement="top" title="Debido al estado del proyecto, no se puede cambiar de fase" style="cursor: not-allowed"><i class="material-icons">edit</i> {{$item->fase}}</button>
                                            </td>
                                            <td>{{$item->enfoque}}</td>
                                            <td>{{$item->trabajo}}</td>
                                            <td>{{$item->indicador}}</td>
                                            @if($item->estado == 'Completado' || $item->estado == 'Terminado' || $item->estado == 'Finalizado' || $item->estado == 'Acabado' || $item->estado == 'Hecho')
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-sm btn-success" @if($rol == 4) clave="{{$item->id}}" onclick="changeEstado(this);" @endif data-toggle="tooltip" data-placement="top" title="Este estado bloquea el proyecto"><i class="material-icons">edit</i> {{$item->estado}}</button>
                                                </td>
                                            @else
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-sm btn-warning" @if($rol == 4) clave="{{$item->id}}" onclick="changeEstado(this);" @endif data-toggle="tooltip" data-placement="top" title="Este estado bloquea el proyecto"><i class="material-icons">edit</i> {{$item->estado}}</button>
                                                </td>
                                            @endif
                                            <td style="text-align: center">
                                                <button type="button" class="btn btn-sm btn-dark text-white" data-toggle="tooltip" data-placement="top" title="Debido al estado del proyecto, no es posible registrar actividades"><i class="material-icons">edit</i> Registrar Actividad</button>
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

        $('.data-table').DataTable({
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

        function AddProyecto() {
            $('#myModal').load('{{ url('/proyectos/new') }}', function (response, status, xhr) {
                if (status == "success")
                    $('#myModal').modal('show');
            });
        }

        function changeEstado(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/proyectos/ChangeStatus') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function changeFase(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/proyectos/ChangeStage') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
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
