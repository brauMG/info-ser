<div class="modal-dialog modal-lg" role="document" style="max-width: 900px;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Roles en este proyecto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        @if($rol === 4)
        <div class="card-header card-header-primary">
            <div style="display: flex; flex-wrap: wrap">
                <div class="col-md-8">
                    <form action="{{route('NewProjectUser')}}">
                        @if($estado == 1)
                            <input type="hidden" name="proyecto" id="proyecto" value="{{$id_proyecto}}">
                            <button type="submit" class="btn btn-info"><i class="material-icons">check</i>Agregar Usuario a Proyecto <i class="material-icons">add_circle_outline</i></button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        @endif
        <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered data-table-modal">
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
                                        <a class="btn btn-sm btn-danger text-white" clave="{{$item->id}}" onclick="changeEstado(this);" data-toggle="tooltip" data-placement="top" title="Este usuario no puede Ver Actividades"><i class="material-icons">edit</i> Inactivo</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
    <script>
        var table = $('.data-table-modal').DataTable({

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

        function AddStage(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/etapas/new_modal') }}/'+clave,function(response, status, xhr){
                if ( status === "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }

        function editStage(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/etapas/edit') }}/'+clave,function(response, status, xhr){
                if ( status === "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }
    </script>
</div>
