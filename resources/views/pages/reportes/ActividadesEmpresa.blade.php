@extends('Shared.layout')
@section('content')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('title', 'Reporte Actividades Empresas')
    <div class="row">
        @include('Shared.sidebar') 
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">           
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

                <h1 class="h2">Reporte Actividad de la Empresa por Enfoque</h1>
            </div>
           
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table">
                            <thead>
                                <tr>
                                    <th>Enfoque</th>
                                    <th>Trabajo</th>                            
                                    <th>Cantidad</th>                            
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reporteEnfoques as $item)
                                    <tr>                                
                                        <td>{{$item->Enfoque}}</td>
                                        <td>{{$item->Trabajo}}</td>
                                        <td>{{$item->Cantidad}}</td>
                                    </tr>    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-12">
                    <div id="chart_Enfoque"></div>        
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover" id="table">
                    <thead>
                        <tr>
                        	<th>Trabajo</th>    
                            <th>Enfoque</th>                                                   
                            <th>Cantidad</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reporteTrabajos as $item)
                            <tr>                           
                            	<td>{{$item->Trabajo}}</td>     
                                <td>{{$item->Enfoque}}</td>                                
                                <td>{{$item->Cantidad}}</td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row"> 
                <div class="col-12">
                    <div id="chart_Trabajo"></div>        
                </div>
            </div>
            
        </main>
    </div>
    <script type="text/javascript">

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChartEnfoque);
      google.charts.setOnLoadCallback(drawChartTrabajo);

      function drawChartEnfoque() {
        var data = new google.visualization.arrayToDataTable([
            ['Total',@foreach($trabajos as $trabajo) {!! "'".$trabajo->Descripcion."',"; !!} @endforeach],
            @foreach($enfoques as $enfoque)
                @php 

                    $isExist=false;
                    $array='';
                @endphp
                @foreach($trabajos as $trabajo) 
                    @php
                        $isExist=false;
                    @endphp
                    @foreach($reporteEnfoques as $reporteEnfoque) 
                        @if($reporteEnfoque->Clave_Trabajo == $trabajo->Clave && $enfoque->Clave==$reporteEnfoque->Clave_Enfoque)
                            @php 
                                $isExist=true; 
                                $array=$array.''.$reporteEnfoque->Cantidad.',';
                            @endphp
                        @endif 
                    @endforeach  
                    @if($isExist==true)
                        
                    @else
                        @php $array=$array.'0,' @endphp
                    @endif
                @endforeach
                ['{{$enfoque->Descripcion}}',{{$array}}],
            @endforeach
            

        ]);        
        var options = {
            'title':'Reporte Actividad Empresa por Enfoque',
            'width':'100%',
            'height':500,
            isStacked: true,
                hAxis: {
                    format: '##'
                },  

        };
        var chart = new google.visualization.BarChart(document.getElementById('chart_Enfoque'));
        chart.draw(data, options);
      }

      function drawChartTrabajo() {
        var data = new google.visualization.arrayToDataTable([
                ['Total',@foreach($enfoques as $enfoque) {!! "'".$enfoque->Descripcion."',"; !!} @endforeach],
                @foreach($trabajos as $trabajo)
                    @php 

                        $isExist=false;
                        $array='';
                    @endphp
                    @foreach($enfoques as $enfoque) 
                        @php
                            $isExist=false;
                        @endphp
                        @foreach($reporteTrabajos as $reporteTrabajo) 
                            @if($reporteTrabajo->Clave_Trabajo == $trabajo->Clave && $enfoque->Clave==$reporteTrabajo->Clave_Enfoque)
                                @php 
                                    $isExist=true; 
                                    $array=$array.''.$reporteTrabajo->Cantidad.','; 
                                @endphp
                            @endif 
                        @endforeach  
                        @if($isExist==true)
                           
                        @else
                            @php $array=$array.'0,' @endphp
                        @endif
                    @endforeach
                    ['{{$trabajo->Descripcion}}',{{$array}}],
                @endforeach
                
            ]);
        /*data.addColumn('string', 'Trabajo Enfoque');
        data.addColumn('number', 'cantidad');
        data.addRows([
            @foreach($reporteTrabajos as $item)
                {!! "[\"".$item->Trabajo. " - ".$item->Enfoque."\" ,".$item->Cantidad."],"!!}
            @endforeach
        ]);*/
        var options = {
            'title':'Reporte Actividad Empresa por Trabajo',
            'width':'100%',
            'height':500,
            isStacked: true,
            hAxis: {
                format: '##'
            }, 
        };
        var chart = new google.visualization.BarChart(document.getElementById('chart_Trabajo'));
        chart.draw(data, options);
      }

      function companiaChange(){
            var compania=$('#compania').val();            
            location.href="{{ url('/Reportes/ActividadesEmpresaPorEnfoque') }}?Compania="+compania;
        }
        $("#nav-ActividadesEmpresaPorEnfoque").addClass("active");
        $('#nav-ActividadesEmpresaPorEnfoque').css({"background": "#9b9634","color": "white"});
    </script>
@endsection