@extends('layouts.app', ['activePage' => 'Roles en Proyectos', 'titlePage' => __('Roles en Proyectos')])

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
                                    <h4 class="card-title ">Roles en Proyectos</h4>
                                    <p class="card-category">Esta lista muestra a que proyecto pertenece cada usuario</p>
                                    <a href="{{route('select')}}" class="btn btn-info" id="new">Agregar Usuario a Proyecto <i class="material-icons">add_circle_outline</i></a>
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
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Usuario</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Puesto</th>
                                    @if($rol == 4 || $rol == 7)
                                        <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Gerencia</th>
                                    @endif
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Proyecto</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Fase actual del proyecto</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Rol RASIC</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Fecha de Asignación</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Estado</th>
                                    </thead>
                                    <tbody>
                                    @foreach ($rolPROYECTO as $item)
                                        <tr>
                                        <td>{{$item->usuario}}</td>
                                        <td>{{$item->puesto}}</td>
                                            @if($rol == 4 || $rol == 7)
                                                <td>{{$item->gerencia}}</td>
                                            @endif
                                        <td>{{$item->proyecto}}</td>
                                        <td>{{$item->fase}}</td>
                                        <td>{{$item->rol_rasic}}</td>
                                        <td style="text-align: center">
                                            <a class="btn btn-sm btn-dark text-white"><i class="material-icons">event_available</i> {{$item->fecha_creacion}}</a>
                                        </td>
                                        @if($item->activo == 1)
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-success text-white" clave="{{$item->id}}" onclick="changeEstado(this);"><i class="material-icons">edit</i> Activo</a>
                                            </td>
                                        @else
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-danger text-white" clave="{{$item->id}}" onclick="changeEstado(this);" data-toggle="tooltip" data-placement="top" title="Este usuario no puede Ver Actividadeses"><i class="material-icons">edit</i> Inactivo</a>
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

        function changeEstado(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/roles-proyectos/ChangeStatus') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }
    </script>
@endsection
