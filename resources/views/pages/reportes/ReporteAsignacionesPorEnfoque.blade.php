@extends('Shared.layout')
@section('content')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('title', 'Reporte de Asignaciones por Enfoque')
    <div class="row">
        @include('Shared.sidebar') 
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">           
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Reporte de Asignaciones por Enfoque</h1>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>Enfoque</label>
                        <select class="form-control" id="enfoque" onchange="enfoqueChange();">
                            <option selected value>Seleccione un Enfoque</option>
                            @foreach($enfoques as $item)
                                <option value="{{$item->Clave}}" @if($Clave_Enfoque==$item->Clave){{"selected='true'"}}@endif>{{$item->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>  
                <div class="col-3">
                    <div class="form-group">
                        <label>Proyecto</label>
                        <select class="form-control" id="proyecto" onchange="proyectoChange();">
                            <option selected value>Seleccione un Proyecto</option>
                            @foreach($proyectos as $item)
                                <option value="{{$item->Clave}}" @if($Clave_Proyecto==$item->Clave){{"selected='true'"}}@endif>{{$item->Descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                              
                <div class="col-3">
                    <div class="form-group">
                        <label class="col-12">&nbsp;</label>
                        <button class="btn btn-info col-12" style="display: none;" id="sendEmail" onclick="sendEmail();">Enviar reporte por correo &nbsp;<i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
            <div class="row"> 
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table">
                            <thead>
                                <tr>                            
                                    <th>Fases</th> 
                                    <th>Actividad</th>
                                    <th>Usuario</th> 
                                    <th>Rol</th>                                 
                                    <th>Decisión</th> 
                                    <th>Fecha Acción</th> 
                                    <th>Estado</th>
                                    <th class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="seleccionarTodos" onclick="selectAll();">
                                            <label class="custom-control-label" for="seleccionarTodos">Seleccionar Todos</label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>                    
                            <tbody>
                                @foreach ($result as $item)
                                    <tr>                                
                                        <td>{{$item->Fases}}</td>
                                        <td>{{$item->Actividad}}</td> 
                                        <td>{{$item->Usuario}}</td>
                                        <td>{{$item->Clave_RASIC}}</td>      
                                        <td>{{$item->Decision}}</td>   
                                        <td>{{$item->FechaAccion}}</td>   
                                        <td>{{$item->Status}}</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input select-rolFase" id="{{$item->Clave_Usuario}}_{{$item->Actividad}}_{{$item->Fases}}" onchange="selectActividadFase('{{$item->Clave_Usuario}}_{{$item->Actividad}}_{{$item->Fases}}');" id-actividad="{{$item->Clave_Actividad}}" id-fase="{{$item->Clave_Fase}}" id-usuario="{{$item->Clave_Usuario}}">
                                                <label class="custom-control-label" for="{{$item->Clave_Usuario}}_{{$item->Actividad}}_{{$item->Fases}}"></label>
                                            </div>
                                        </td>
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
        google.charts.setOnLoadCallback(drawChartEnfoque);
        function drawChartEnfoque() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Enfoque Trabajo');
            data.addColumn('number', 'cantidad');
            data.addRows([
                /*foreach($enfoques as $item)
                   
                endforeach*/
                ["prueba",5]
            ]);
            var options = {'title':'Reporte Actividad Empresa por Enfoque',
                           'width':'100%',
                           'height':500};
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_Enfoque'));
            chart.draw(data, options);
        }
        function selectAll(){
            var checkBox = document.getElementById("seleccionarTodos");
            if (checkBox.checked == true){
                $('.select-rolFase').prop('checked',true);
                $('#sendEmail').fadeIn();
            } else {  
                $('.select-rolFase').prop('checked',false);
                 $('#sendEmail').fadeOut();
            }            
        }
        function selectActividadFase($id){
            var checkBox = document.getElementById($id);
            if (checkBox.checked == true){
                $('#sendEmail').fadeIn();                
                var actividad=checkBox.attributes["id-actividad"].value;
                var fases=checkBox.attributes["id-fase"].value;
                var checkBoxes = document.getElementsByClassName("select-rolFase");
                for(var i=0; i<checkBoxes.length; i++){
                    if (checkBoxes[i].attributes["id-actividad"].value == actividad && checkBoxes[i].attributes["id-fase"].value==fases){
                        checkBoxes[i].checked=true
                    }
                }                
            }else{
                var checked=false;
                var actividad=checkBox.attributes["id-actividad"].value;
                var fases=checkBox.attributes["id-fase"].value;
                var checkBoxes = document.getElementsByClassName("select-rolFase");
                for(var i=0; i<checkBoxes.length; i++){
                    if (checkBoxes[i].attributes["id-actividad"].value == actividad && checkBoxes[i].attributes["id-fase"].value==fases){
                        checkBoxes[i].checked=false                        
                    }
                    if (checkBoxes[i].checked == true){
                        checked=true
                    }                    
                }                
                if(checked==false){
                    $('#sendEmail').fadeOut();
                }
            }
        }

        @if(Auth::user()->Clave_Rol==1)
            function companiaChange(){
                var compania=$('#compania').val();            
                location.href="{{url('/Reportes/Proyectos')}}?Compania="+compania;
            }
        @endif        
        function proyectoChange(){
            var compania='{{Auth::user()->Clave_Compania}}';

            var enfoque=$('#enfoque').val();
            var proyecto=$('#proyecto').val();
            
            location.href="{{ url('/Reportes/Proyectos') }}?Compania="+compania+"&Enfoque="+enfoque+"&Proyecto="+proyecto;
        }
        function enfoqueChange(){
            var compania='{{Auth::user()->Clave_Compania}}';             
            var Enfoque = $('#enfoque').val();
            location.href="{{ url('/Reportes/Proyectos') }}?Compania="+compania+"&Enfoque="+Enfoque;
        }
        
        function sendEmail(){
            var checkBoxes          =   document.getElementsByClassName("select-rolFase");            
            var FasesActividades    =   [];
            var FaseActividad       =   [];
            var index               =   0;
            var isNew               =   true;
            var actividad           =   "";
            var fase                =   "";
            var usuario             =   "";
            for(var i=0; i<checkBoxes.length; i++){
                var actividad       =   checkBoxes[i].attributes["id-actividad"].value;
                var fase            =   checkBoxes[i].attributes["id-fase"].value;
                var usuario         =   checkBoxes[i].attributes["id-usuario"].value;

                if(checkBoxes[i].checked==true){
                        FaseActividad=
                        {
                            Fase:       fase, 
                            Actividad:  actividad,
                            Usuarios:   []
                        };
                    

                    if(FasesActividades.some(item=>item.Fase==fase&&item.Actividad==actividad)==false){
                        FaseActividad.Usuarios.push({Usuario:usuario});
                        index=FasesActividades.push(FaseActividad);
                        console.log("index:"+index);
                        
                    }else{
                        FasesActividades[(index-1)].Usuarios.push({Usuario:usuario});
                    }
                }               
            }
            console.log(FasesActividades);
            var error=false;
            for(var i=0; i<FasesActividades.length; i++){
                console.log(FasesActividades[i]);
                console.log(FasesActividades[i].Usuarios);
                var usuariosString="";
                for(var j=0; j<FasesActividades[i].Usuarios.length; j++){
                    usuariosString+=FasesActividades[i].Usuarios[j].Usuario+",";
                }
                console.log(usuariosString);
                $.get("{{ url('/Email/SendReporteAsignacionesEnfoque') }}?Usuarios="+usuariosString.substring(0,usuariosString.length-1)+"&Proyecto={{$Clave_Proyecto}}&Fase="+FasesActividades[i].Fase+"&Actividad="+FasesActividades[i].Actividad,function(data){
                    /*if(data.error==false){
                        Swal.fire({
                            type: 'success',
                            title: 'Listo',
                            text: 'Correos enviados Correctamente'
                        })
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Error',
                            text: data.responseJSON.message
                        })
                    }*/
                }).fail(function(){                    
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'Error al enviar correo'
                    })
                }).done(function(){
                    Swal.fire({
                        type: 'success',
                        title: 'Listo',
                        text: 'Correos enviados Correctamente'
                    })
                });
            }            
        }
        $("#nav-ReporteEnfoque").addClass("active");
        $('#nav-ReporteEnfoque').css({"background": "#9b9634","color": "white"});
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