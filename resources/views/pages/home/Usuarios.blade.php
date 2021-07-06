@extends('Shared.layout')
@section('content')
@section('title', 'Nueva Actividad')
@section('company',$compania->Descripcion)
	<div class="row">
        @include('Shared.sidebar')
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"> Usuarios</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="new">Enviar Correos <i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
            <div id="Alert">

            </div>

            <div class="table-responsive">
                <table class="table table-hover" id="table">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Compañía</th>
                            <th>Nombre(s)</th>
                            <th>Correo</th>
                            <th>Area</th>
                            <th>Puesto</th>
                            <th>Rol</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $item)
                            <tr id="{{$item->Clave}}">
                                <td>{{$item->Clave}}</td>
                                <td>{{$item->Compania}}</td>
                                <td>{{$item->Nombres}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->Area}}</td>
                                <td>{{$item->Puesto}}</td>
                                <td>{{$item->Rol}}</td>

                                <td class="text-right">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                    	@php
                                    		$isExist =false;
                                    		$isExistFase=false;
                                    	@endphp
                                    	@foreach($rolesProyectos as $rolProyecto)
                                    		@if($rolProyecto->Clave_Usuario==$item->Clave)
                                    			@php
                                    				$isExist=true;
                                    			@endphp
                                    		@endif
                                    	@endforeach



                                        @if($isExist==true)
                                        	<button type="button" class="btn btn-danger btn-sm" clave="{{$item->Clave}}" onclick="delete_proyect(this);">
                                        		Quitar Usuario del Proyecto
                                        	</button>
                                        @else
                                        	<button type="button" class="btn btn-success btn-sm" clave="{{$item->Clave}}" onclick="add_proyect(this);">
                                        		Agregar Usuario al Proyecto
                                        	</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script type="text/javascript">
    	function add_proyect(button){
            var clave = $(button).attr('clave');
            var tr=$(button).closest('tr');
    		$.get('{{url('/home/Add/Proyecto')}}?id='+clave+'&proyecto={!!$Clave_Proyecto!!}&fase={!!$Clave_Fase!!}',function(result){
                var table=$('#table').DataTable();


                 if(result.error==false){
                    var info=table.row(tr)
                    .data();
                    info[7]='<button type="button" class="btn btn-danger btn-sm" clave="'+clave+'" onclick="delete_proyect(this);"> Eliminar Usuario del Proyecto </button>';
                    table
                    .row( tr )
                    .data( info )
                    .draw();

                    Swal.fire
                    (
                        'Listo',
                        'Tu registro ha sido cambiado',
                        'success'
                    )
                }
    		})
            .fail(function(data){
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: data.responseJSON.message
                })
            });

    	};
    	function delete_proyect(button){
            var clave = $(button).attr('clave');
            var tr=$(button).closest('tr');
    		$.get('{{url('/home/deletes/Proyecto')}}?id='+clave+'&proyecto={!!$Clave_Proyecto!!}&fase={!!$Clave_Fase!!}',function(result){
                var table=$('#table').DataTable();

                 if(result.error==false){
                    var info=table.row(tr)
                    .data();
                    info[7]='<button type="button" class="btn btn-success btn-sm" clave="'+clave+'" onclick="add_proyect(this);"> Agregar Usuario al Proyecto </button>';
                    table
                    .row( tr )
                    .data( info )
                    .draw();

                    Swal.fire
                    (
                        'Listo',
                        'Tu registro ha sido cambiado',
                        'success'
                    )
                }

    		})
            .fail(function(data){
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: data.responseJSON.message
                })
            });

    	}
        $(document).ready(function(){
            var table=$('#table').DataTable({
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
            $('#new').click(function(){
                $.get('{{url('/home/email/nuevaactividad')}}?&proyecto={!!$Clave_Proyecto!!}&fase={!!$Clave_Fase!!}&descripcion={!! $descripcion !!}&decision={!! $decision !!}&fechaAccion={!! $fechaAccion!!}',function(result){
                    if(result.error==false){
                        Swal.fire
                        (
                            'Listo',
                            'Se han enviado los correos correctamente',
                            'success'
                        ).then(function(){
                             location.href="{{ url('/home') }}";
                        });
                    }
                });
            });

        });
    </script>
@endsection
