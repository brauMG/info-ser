@extends('layouts.app', ['activePage' => 'Usuarios', 'titlePage' => __('Usuarios')])

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
                            <h4 class="card-title ">Lista de Usuarios</h4>
                            <p class="card-category">Estos son los usuarios registrados en el sistema</p>
                            <button type="button" class="btn btn-info" id="new" onclick="AddUser();">Agregar Usuario <i class="material-icons">add_circle_outline</i></button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered data-table">
                                    <thead class="text-primary thead-color">
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">ID</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Compañia</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Nombres</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Correo</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Área</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Puesto</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Rol</th>
                                    <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Recibe Correo</th>
                                    <th class="action-row">Acción</th>
                                    </thead>
                                    <tbody>
                                    @foreach ($usuarios as $item)
                                        <tr>
                                            <td>{{$item->id}}<i class="material-icons plus">add_circle</i></td>
                                            <td>{{$item->compania}}</td>
                                            <td>{{$item->nombres}}</td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->area}}</td>
                                            <td>{{$item->puesto}}</td>
                                            <td>{{$item->rol}}</td>
                                            @if($item->send == 0)
                                                <td style="text-align: center">
                                                    <button class="btn btn-sm btn-danger btn-adjust" clave="{{$item->id}}" onclick="changeSend(this);">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            @else
                                                <td style="text-align: center">
                                                    <button class="btn btn-sm btn-success btn-adjust" clave="{{$item->id}}" onclick="changeSend(this);">
                                                        <i class="material-icons">check</i>
                                                    </button>
                                                </td>
                                            @endif
                                            <td class="action-row">
                                                <button clave="{{$item->id}}" onclick="edit(this);" type="button" rel="tooltip" class="btn btn-sm btn-warning btn-adjust">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                                <button clave="{{$item->id}}" onclick="deleted(this);" type="button" rel="tooltip" class="btn btn-sm btn-danger btn-adjust">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </td>
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
        $('.data-table').DataTable({

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

        function AddUser() {
            $('#myModal').load( '{{ url('/usuarios/new') }}',function(response, status, xhr)
            {
                if (status == "success")
                    $('#myModal').modal('show');
            });
        }

        function changeSend(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/usuarios/ChangeSend') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function edit(button){
            console.warn('edit');
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/usuarios/edit') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function deleted(button){
            console.warn('delete');
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/usuarios/delete') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }
    </script>
@endsection
