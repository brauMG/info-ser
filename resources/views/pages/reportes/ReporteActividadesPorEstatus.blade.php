@extends('Shared.layout')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('title', 'Reporte Actividades Por Estatus')
@section('content')

    <div class="row">
        @include('Shared.sidebar') 
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">           
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Reporte Actividad por Estatus</h1>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover" id="table">
                    <thead>
                        <tr>
                            <th>Fecha Acción</th>
                            <th>Estado</th>                            
                            <th>Enfoque</th>                            
                            <th>Trabajo</th>                       
                            <th>Fase</th>                       
                            <th>Participante</th> 
                            <th>RolRASIC</th>                           
                            <th>Decisión</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($activity as $item)
                            <tr>                                
                                <td>{{$item->FechaAccion}}</td>
                                <td>{{$item->Status}}</td>
                                <td>{{$item->Enfoque}}</td>
                                <td>{{$item->Trabajo}}</td>
                                <td>{{$item->Fase}}</td>
                                <td>{{$item->Participante}}</td>
                                <td>{{$item->RolRASIC}}</td>
                                <td>{{$item->Decision}}</td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div> 
    <script type="text/javascript">
        $("#nav-ReporteStatus").addClass("active");
        $('#nav-ReporteStatus').css({"background": "#9b9634","color": "white"});
        //Blfrtip
        var table=$('#table').DataTable({
            dom: 
                '<"row" <"col-4 col-md-4" l> <"col-4 col-md-4 text-center" B> <"col-4 col-md-4" f>>'+
                "<'row'<'col-12'tr>>" +
                "<'row'<'col-3'i><'col-9 text-center'p>>",
            buttons: [
                'excel'
            ],
            language:
                {
                    processing: "Cargando",
                    search: "_INPUT_",
                    searchPlaceholder: "Buscar en Registros",
                    lengthMenu: "Mostrar _MENU_ Registros",
                    info: "Registros _START_  al  _END_  de _TOTAL_",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros)",
                    oPaginate:
                        {
                            sFirst: "Primero",
                            sPrevious: "Anterior",
                            sNext: "Siguiente",
                            sLast: "Ultimo"
                        },
                    zeroRecords: "No hay registros"
                }

        });
        function companiaChange(){
            var compania=$('#compania').val();            
            location.href="{{ url('/Reportes/ActividadesEmpresaPorStatus') }}?Compania="+compania;
        }
    </script> 
@endsection