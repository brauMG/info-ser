@extends('layouts.app', ['activePage' => 'Etapas', 'titlePage' => __('Etapas')])

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
                                    <h4 class="card-title ">Lista de Etapas</h4>
                                    <p class="card-category">Estas son las etapas registradas para los proyectos</p>
                                    <button type="button" class="btn btn-info" id="new" onclick="AddEtapa();">Agregar Etapa <i class="material-icons">add_circle_outline</i></button>
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
                                    <th>ID<i class="material-icons sort">sort</i></th>
                                    @if($rol == 4 || $rol == 7)
                                        <th>Gerencia<i class="material-icons sort">sort</i></th>
                                    @endif
                                    <th>Proyecto<i class="material-icons sort">sort</i></th>
                                    <th>Fase del proyecto<i class="material-icons sort">sort</i></th>
                                    <th>Descripción<i class="material-icons sort">sort</i></th>
                                    <th>Fecha de Vencimiento<i class="material-icons sort">sort</i></th>
                                    <th>Hora de Vencimiento<i class="material-icons sort">sort</i></th>
                                    <th>Fecha de Creación<i class="material-icons sort">sort</i></th>
                                    <th>Acción<i class="material-icons sort">sort</i></th>
                                    </thead>
                                    <tbody>
                                    @foreach ($etapa as $item)
                                        <tr>
                                            <td>{{$item->id}}<i class="material-icons plus">add_circle</i></td>
                                            @if($rol == 4 || $rol == 7)
                                                <td>{{$item->gerencia}}</td>
                                            @endif
                                            <td>{{$item->proyecto}}</td>
                                            <td>{{$item->fase}}</td>
                                            <td>{{$item->descripcion}}</td>
                                            @if($date == $item->fecha_vencimiento)
                                                @if($time > $item->hora_vencimiento)
                                                    <td style="text-align: center">
                                                        <a class="btn btn-sm btn-danger text-white"><i class="material-icons">event_busy</i> Vencio hoy: {{$item->fecha_vencimiento}}</a>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a class="btn btn-sm btn-danger text-white"><i class="material-icons">event_busy</i> Vencio hoy a las: {{$item->hora_vencimiento}}</a>
                                                    </td>
                                                @else
                                                    <td style="text-align: center">
                                                        <a class="btn btn-sm btn-warning text-white"><i class="material-icons">event_busy</i> Vence hoy: {{$item->fecha_vencimiento}}</a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-warning text-white"><i class="material-icons">date_range</i> Vence hoy a las: {{$item->hora_vencimiento}}</a>
                                                    </td>
                                                @endif
                                            @elseif($date < $item->fecha_vencimiento)
                                                <td style="text-align: center">
                                                    <a class="btn btn-sm btn-success text-white"><i class="material-icons">event_available</i> Vence el: {{$item->fecha_vencimiento}}</a>
                                                </td>
                                                    <td style="text-align: center">
                                                    <a class="btn btn-sm btn-success text-white"><i class="material-icons">event_available</i> Vence a las: {{$item->hora_vencimiento}}</a>
                                                </td>
                                            @else
                                                <td style="text-align: center">
                                                    <a class="btn btn-sm btn-danger text-white"><i class="material-icons">event_busy</i> Vencio el: {{$item->fecha_vencimiento}}</a>
                                                </td>
                                                    <td style="text-align: center">
                                                    <a class="btn btn-sm btn-danger text-white"><i class="material-icons">event_busy</i> Vencio a las: {{$item->hora_vencimiento}}</a>
                                                </td>
                                            @endif
                                            <td style="text-align: center">
                                                <a class="btn btn-sm btn-dark text-white"><i class="material-icons">event_busy</i> {{$item->creado}}</a>
                                            </td>
                                            <td class="action-row">
                                                <button clave="{{$item->id}}" onclick="edit(this);" type="button" rel="tooltip" class="btn btn-sm btn-warning btn-adjust">
                                                    <i class="material-icons">edit</i>
                                                </button>
{{--                                                <button clave="{{$item->id}}" onclick="deleted(this);" type="button" rel="tooltip" class="btn btn-sm btn-danger btn-adjust">--}}
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
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

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

        $('#gerencia-filter').on('change', function(){
            table.search(this.value).draw();
        });

        function AddEtapa() {
            $('#myModal').load( '{{ url('/etapas/new') }}',function(response, status, xhr)
            {
                if (status == "success")
                    $('#myModal').modal('show');
            });
        }

        function edit(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/etapas/edit') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function deleted(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/etapas/delete') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

    </script>
@endsection
