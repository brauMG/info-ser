<div class="modal-dialog modal-lg" role="document" style="max-width: 900px;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Etapas de este proyecto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <div class="card-header card-header-primary">
            <div style="display: flex; flex-wrap: wrap">
                <div class="col-md-8">
                    <button clave="{{$id_proyecto}}" type="button" class="btn btn-info" id="new" onclick="AddStage(this);">Agregar Etapa <i class="material-icons">add_circle_outline</i></button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered data-table-modal">
                    <thead class="text-primary thead-color">
                    <th style="font-size: 14px">ID</th>
                    @if($rol == 4 || $rol == 7)
                        <th data-toggle="tooltip" data-placement="top" title="presiona para ordenar" style="cursor: pointer">Gerencia</th>
                    @endif
                    <th style="font-size: 14px">Proyecto<i class="material-icons sort" style="font-size: 12px">sort</i></th>
                    <th style="font-size: 14px">Fase del proyecto<i class="material-icons sort" style="font-size: 12px">sort</i></th>
                    <th style="font-size: 14px">Descripción<i class="material-icons sort" style="font-size: 12px">sort</i></th>
                    <th style="font-size: 14px">Fecha de Vencimiento<i class="material-icons sort" style="font-size: 12px">sort</i></th>
                    <th style="font-size: 14px">Hora de Vencimiento<i class="material-icons sort" style="font-size: 12px">sort</i></th>
                    <th style="font-size: 14px">Fecha de Creación<i class="material-icons sort" style="font-size: 12px">sort</i></th>
                    @if($rol === 4 || $rol === 7)
                        <th style="font-size: 14px">Acción<i class="material-icons sort" style="font-size: 12px">sort</i></th>
                    @endif
                    </thead>
                    <tbody>
                    @foreach ($etapa as $item)
                        <tr>
                            <td style="font-size: 12px">{{$item->id}}<i class="material-icons plus">add_circle</i></td>
                            @if($rol == 4 || $rol == 7)
                                <td style="font-size: 12px">{{$item->gerencia}}</td>
                            @endif
                            <td style="font-size: 12px">{{$item->proyecto}}</td>
                            <td style="font-size: 12px">{{$item->fase}}</td>
                            <td style="font-size: 12px">{{$item->descripcion}}</td>
                            @if($date == $item->fecha_vencimiento)
                                @if($time > $item->hora_vencimiento)
                                    <td style="text-align: center; font-size: 12px">
                                        <a class="btn btn-sm btn-danger text-white"><i class="material-icons">event_busy</i> Vencio hoy: {{$item->fecha_vencimiento}}</a>
                                    </td>
                                    <td style="text-align: center; font-size: 12px">
                                        <a class="btn btn-sm btn-danger text-white"><i class="material-icons">event_busy</i> Vencio hoy a las: {{$item->hora_vencimiento}}</a>
                                    </td>
                                @else
                                    <td style="text-align: center; font-size: 12px">
                                        <a class="btn btn-sm btn-warning text-white"><i class="material-icons">event_busy</i> Vence hoy: {{$item->fecha_vencimiento}}</a>
                                    </td>
                                    <td style="text-align: center; font-size: 12px">
                                        <a class="btn btn-sm btn-warning text-white"><i class="material-icons">date_range</i> Vence hoy a las: {{$item->hora_vencimiento}}</a>
                                    </td>
                                @endif
                            @elseif($date < $item->fecha_vencimiento)
                                <td style="text-align: center; font-size: 12px">
                                    <a class="btn btn-sm btn-success text-white"><i class="material-icons">event_available</i> Vence el: {{$item->fecha_vencimiento}}</a>
                                </td>
                                <td style="text-align: center; font-size: 12px">
                                    <a class="btn btn-sm btn-success text-white"><i class="material-icons">event_available</i> Vence a las: {{$item->hora_vencimiento}}</a>
                                </td>
                            @else
                                <td style="text-align: center; font-size: 12px">
                                    <a class="btn btn-sm btn-danger text-white"><i class="material-icons">event_busy</i> Vencio el: {{$item->fecha_vencimiento}}</a>
                                </td>
                                <td style="text-align: center; font-size: 12px">
                                    <a class="btn btn-sm btn-danger text-white"><i class="material-icons">event_busy</i> Vencio a las: {{$item->hora_vencimiento}}</a>
                                </td>
                            @endif
                            <td style="text-align: center; font-size: 12px">
                                <a class="btn btn-sm btn-dark text-white"><i class="material-icons">event_busy</i> {{$item->creado}}</a>
                            </td>
                            @if($rol === 4 || $rol === 7)
                            <td class="action-row" style="font-size: 12px">
                                <button clave="{{$item->id}}" onclick="editStage(this);" type="button" rel="tooltip" class="btn btn-sm btn-warning btn-adjust">
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
