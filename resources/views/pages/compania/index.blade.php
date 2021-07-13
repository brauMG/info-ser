@extends('layouts.app', ['activePage' => 'Compañias', 'titlePage' => __('Compañias')])

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
                            <h4 class="card-title ">Lista de Compañias</h4>
                            <p class="card-category">Estas son las compañias registradas en el sistema</p>
                            <button type="button" class="btn btn-info" id="new" onclick="AddCompany();">Agregar Compañia <i class="material-icons">add_circle_outline</i></button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered companies-table">
                                    <thead class="text-primary thead-color">
                                    <th>ID<i class="material-icons sort">sort</i></th>
                                    <th>Descripción<i class="material-icons sort">sort</i></th>
                                    <th>Dominio<i class="material-icons sort">sort</i></th>
                                    <th class="action-row">Acción</th>
                                    </thead>
                                    <tbody>
                                    @foreach ($company as $item)
                                        <tr>
                                            <td>{{$item->id}}<i class="material-icons plus">add_circle</i></td>
                                            <td>{{$item->descripcion}}</td>
                                            <td>{{$item->dominio}}</td>
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
            $('.companies-table').DataTable({
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

        function AddCompany() {
            $('#myModal').load( '{{ url('/companias/new') }}',function(response, status, xhr)
            {
                if (status == "success")
                    $('#myModal').modal('show');
            });
        }

        function edit(button){
            console.warn('edit');
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/companias/edit') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function deleted(button){
            console.warn('delete');
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/companias/delete') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }
    </script>
@endsection
