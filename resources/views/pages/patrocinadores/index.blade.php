@extends('layouts.app', ['activePage' => 'Patrocinadores', 'titlePage' => __('Patrocinadores')])

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
                            <h4 class="card-title ">Lista de Patrocinadores</h4>
                            <p class="card-category">Estas son los patrocinadores del sistema</p>
                            <button type="button" class="btn btn-info" id="new" onclick="AddSponsor();">Agregar Patrocinador <i class="material-icons">add_circle_outline</i></button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered data-table">
                                    <thead class="text-primary thead-color">
                                    <th>ID<i class="material-icons sort">sort</i></th>
                                    <th>Imagen<i class="material-icons sort">sort</i></th>
                                    <th>Nombre<i class="material-icons sort">sort</i></th>
                                    <th>Descripción<i class="material-icons sort">sort</i></th>
                                    <th>Enlace<i class="material-icons sort">sort</i></th>
                                    <th class="action-row">Acción</th>
                                    </thead>
                                    <tbody>
                                    @foreach ($sponsors as $sponsor)
                                        <tr>
                                            <td>{{$sponsor->id}}<i class="material-icons plus">add_circle</i></td>
                                            <td style="text-align: center"><img src="{{ URL::to('/') }}/sponsors/{{ $sponsor->imagen }}" width="100" /></td>
                                            <td>{{$sponsor->nombre}}</td>
                                            <td>{{substr($sponsor->description, 0, 115)}}...</td>
                                            <td>{{$sponsor->enlace}}</td>
                                            <td class="action-row">
                                                <button clave="{{$sponsor->id}}" onclick="edit(this);" type="button" rel="tooltip" class="btn btn-sm btn-warning btn-adjust">
                                                    <i class="material-icons">edit</i>
                                                </button>
{{--                                                <button clave="{{$sponsor->id}}" onclick="deleted(this);" type="button" rel="tooltip" class="btn btn-sm btn-danger btn-adjust">--}}
{{--                                                    <i class="material-icons">delete</i>--}}
{{--                                                </button>--}}
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

        function AddSponsor() {
            $('#myModal').load( '{{ url('/patrocinadores/new') }}',function(response, status, xhr)
            {
                if (status == "success")
                    $('#myModal').modal('show');
            });
        }

        function edit(button){
            console.warn('edit');
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/patrocinadores/edit') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function deleted(button){
            console.warn('delete');
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/patrocinadores/delete') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }
    </script>
@endsection
