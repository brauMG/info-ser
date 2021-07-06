@extends('Shared.layout')
@section('content')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('title', 'Nueva Actividad')
    <div class="row">
        @include('Shared.sidebar') 
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">           
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

                <h1 class="h2">Actividades</h1>                
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Descripción</label>
                        <input class="form-control" type="text" id="descripcion" name="descripcion">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                    </div>
                </div>
            
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Proyectos</label>
                        <select class="form-control" name="proyectos" id="proyectos" onchange="getUsers()">
                            <option selected="true" value disabled="true">Selecciona Proyecto</option>
                            @foreach ($proyectos as $item)
                                <option value="{{$item->Clave}}" area="{{$item->Clave_Area}}" fase="{{$item->Clave_Fase}}" enfoque="{{$item->Clave_Enfoque}}" trabajo="{{$item->Clave_Trabajo}}" indicador="{{$item->Clave_Indicador}}" objectivo="{{$item->Objectivo}}">{{$item->Descripcion}}</option>
                            @endforeach
                        </select>
                        
                    </div>
                </div>
            </div>
            <div class="row">                
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Áreas</label>
                        <select class="form-control" name="areas" id="areas" disabled="true">                            
                            <option selected="true" value disabled="true">Selecciona Proyecto</option>
                            @foreach ($areas as $item)
                                <option value="{{$item->Clave}}">{{$item->Descripcion}}</option>
                            @endforeach
                        </select>                        
                    </div>
                </div>
                @if(Auth::user()->Clave_Rol!=4)
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Fases</label>
                        <select class="form-control" name="fases" id="fases" disabled="true">
                            @foreach ($fases as $item)
                                <option value="{{$item->Clave}}">{{$item->Descripcion}}</option>
                            @endforeach
                        </select>                        
                    </div>
                </div>
                @else  
                 <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Fases</label>
                        <select class="form-control" name="fases" id="fases">
                            @foreach ($fases as $item)
                                <option value="{{$item->Clave}}">{{$item->Descripcion}}</option>
                            @endforeach
                        </select>                        
                    </div>
                </div>
                @endif             
            </div>
            <div class="row">
                
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Estado</label>
                        <select class="form-control" name="status" id="status">
                            @foreach ($status as $item)
                                <option value="{{$item->Clave}}">{{$item->Status}}</option>
                            @endforeach
                        </select>
                        
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Próxima Actividad</label>
                        <input class="form-control" name="decision" id="decision"/>
                        
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Enfoque</label>
                        <select class="form-control" id="enfoque" disabled="true">
                            <option>Seleccionar proyecto</option>
                            @foreach($enfoques as $enfoque)
                                <option value="{{$enfoque->Clave}}">{{$enfoque->Descripcion}}</option>
                            @endforeach
                        </select>
                        
                    </div>
                </div>
            </div>
            <div class="row">
               
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Trabajo</label>
                        <select class="form-control" id="trabajo" disabled="true" disabled="true">
                            <option>Seleccionar proyecto</option>
                            @foreach($trabajos as $trabajo)
                                <option value="{{$trabajo->Clave}}">{{$trabajo->Descripcion}}</option>
                            @endforeach
                        </select>
                        
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Indicador</label>
                        <select class="form-control" id="indicador" disabled="true">
                            <option>Seleccionar proyecto</option>
                            @foreach($indicadores as $indicador)
                                <option value="{{$indicador->Clave}}">{{$indicador->Descripcion}}</option>
                            @endforeach
                        </select>
                        
                    </div>
                </div>
                 <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Objectivo</label>
                        <input type="text" class="form-control" id="objectivo" disabled="true">                    
                    </div>
                </div>                
            </div>
            <div class="row">
               
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Fecha de próxima revisión</label>
                        <input class="form-control" name="FechaAccion" id="FechaAccion" type="date" />                        
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="form-group">
                        <button class="btn btn-success" id="btn_save">Guardar Actividad <i class="fas fa-save"></i> </button>
                    </div>
                </div>
            </div>
            

        </main>
    </div>
    <script type="text/javascript">        
        $("#nav-home").addClass("active");
        $('#nav-home').css({"background": "#9b9634","color": "white"});
        function getUsers(){
            var Proyecto=$('#proyectos').val();
            //$('#').val(Proyecto);
            var proyecto=document.getElementById("proyectos");
            var area=proyecto.options[proyecto.selectedIndex].getAttribute('area');
            var fase=proyecto.options[proyecto.selectedIndex].getAttribute('fase');
            var enfoque=proyecto.options[proyecto.selectedIndex].getAttribute('enfoque');
            var trabajo=proyecto.options[proyecto.selectedIndex].getAttribute('trabajo');
            var indicador=proyecto.options[proyecto.selectedIndex].getAttribute('indicador');
            var objectivo=proyecto.options[proyecto.selectedIndex].getAttribute('objectivo');
            console.log(area);
            $('#areas').val(area);
            $('#fases').val(fase);
            $('#enfoque').val(enfoque);
            $('#trabajo').val(trabajo);
            $('#indicador').val(indicador);
            $('#objectivo').val(objectivo);
            /*$.get('{{ url('/Admin/Usuarios/UsersByProyect') }}/'+Proyecto,function(data){
                var options="<option value='all' >Todos</option>";
                data.usuarios.forEach(function(item,index){
                    options=options+"<option value='"+item.Clave+"'>"+ item.Nombres+"</option>";
                });
                $('#usuarios').html(options);
            });*/
        }
        function getProjects(){
            var Compania=$('#compania').val();
            $.get('{{ url('/Admin/Proyectos/ProyectByCompany') }}/'+Compania,function(data){
                var options="<option value selected='true' disabled='true'>Seleccionar poryecto</option>";
                data.proyectos.forEach(function(item,index){
                    options=options+"<option value='"+item.Clave+"' area='"+item.Clave_Area+"' enfoque='"+item.Clave_Enfoque+"' trabajo='"+item.Clave_Trabajo+"' indicador='"+item.Clave_Indicador+"' fase='"+item.Clave_Fase+"' >"+ item.Descripcion+"</option>";
                });
                $('#proyectos').html(options);
            });
        }
        $('#btn_save').click(function(){
            var proyecto=$('#proyectos').val();
            var area=$('#areas').val();
            var fase=$('#fases').val();
            var description=$('#descripcion').val();
            var fechaAccion=$('#FechaAccion').val();
            var decision=$('#decision').val();
            var status=$('#status').val();
            
            window.location.href='{{url('/home/create')}}?compania={{$compania->Clave}}&proyecto='+proyecto+'&fase='+fase+'&descripcion='+description+'&fechaAccion='+fechaAccion+'&decision='+decision+'&status='+status;        
        });
    </script>
@endsection