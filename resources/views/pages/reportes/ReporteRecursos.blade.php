@extends('Shared.layout')
@section('content')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('title', 'Reporte Recursos')
    <div class="row">
        @include('Shared.sidebar') 
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">           
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2" onclick="tableToExcel('table', 'W3C Example Table')">Reporte Recursos</h1>

            </div>            
            @php
                $proyectos=[];
                $usuarios=[];
            @endphp
            <div class="row">
                <div class="col-12 col-md-12">
                    <div id="chart_occupation" style="width:100%;"></div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive" id="table-conta">
                        <table class="table table-hover" id="table">
                            <thead>
                                <tr>
                                    <th>Recursos</th>
                                    <th>Proyecto</th>
                                    <th>Rol RASIC</th>                            
                                    <th>Enfoque</th>                            
                                    <th>Trabajo</th>                       
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rol as $item)
                                    @if(!in_array($item->Proyecto, $proyectos))
                                        @php 
                                            array_push($proyectos,$item->Proyecto);
                                        @endphp
                                    @endif
                                    @if(!in_array($item->Recursos, $usuarios))
                                        @php 
                                            array_push($usuarios,$item->Recursos);
                                        @endphp
                                    @endif
                                    <tr>
                                        <td>{{$item->Recursos}}</td>   
                                        <td>{{$item->Proyecto}}</td>
                                        <td>{{$item->RolRASIC}}</td>
                                        <td>{{$item->Enfoque}}</td>
                                        <td>{{$item->Trabajo}}</td>
                                    </tr>    
                                @endforeach                                
                            </tbody>
                        </table>
                    </div>
                </div>                
            </div>
            
        </main>
    </div>  
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        if('{{$Clave_Compania}}'!=''){
            google.charts.setOnLoadCallback(drawChartocupation);
        }
        

        function drawChartocupation() {
            var data = new google.visualization.arrayToDataTable([
                ['Total', @foreach($proyectos as $item) {!! "'".$item."',"; !!} @endforeach ],
                    @foreach($usuarios as $usuario)                        
                        @php
                            $isExist=false;
                            $array="\n['".$usuario."',";
                        @endphp
                        @foreach($proyectos as $proyecto)
                            @php
                                $isExist=false;                            
                            @endphp
                            @foreach ($rol as $item)
                                @if($item->Proyecto==$proyecto && $item->Recursos==$usuario)
                                    @php
                                        $isExist=true;                                        
                                    @endphp
                                @endif
                            @endforeach
                            @if($isExist==true)
                                @php $array=$array."1,"; @endphp
                            @else
                                @php $array=$array."0,"; @endphp
                            @endif
                        @endforeach
                        @php 
                            $array=$array."],\n";
                        @endphp
                        {!!  $array !!}
                    @endforeach
                ]);            

            var options = {
                'title':'Reporte de Recursos',
                'width':'100%',
                'height':500, 
                isStacked: true,
                hAxis: {
                    format: '##'
                },            
            };
            
            var chart_occupation=document.getElementById('chart_occupation');
            var chart = new google.visualization.BarChart(chart_occupation);            
            
            chart.draw(data, options);
            

        }

        
        $("#nav-ReportRecursos").addClass("active");
        $('#nav-ReportRecursos').css({"background": "#9b9634","color": "white"});
        var table=$('#table').DataTable({
            dom: 
                '<"row" <"col-4 col-md-4" > <"col-4 col-md-4 text-center" B> <"col-4 col-md-4" f>>'+
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
                },
            "bLengthChange": false,
            "bPaginate": false
        });
         
    </script>
@endsection