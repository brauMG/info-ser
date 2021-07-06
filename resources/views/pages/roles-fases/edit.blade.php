<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar RolFase</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Pryecto</label>
                        <select class="form-control" name="proyecto" id="proyecto">
                            @foreach ($proyectos as $item)
                                <option value="{{$item->Clave}}">{{$item->Descripcion}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                        <input type="hidden" name="clave" value="{{ $rolFase->Clave }}" id="clave"/>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Fase</label>
                        <select class="form-control" name="fase" id="fase">
                            @foreach ($fases as $item)
                                <option value="{{$item->Clave}}">{{$item->Descripcion}}</option>
                            @endforeach
                        </select>                        
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Rol RASIC</label>
                        <select class="form-control" name="rolRASIC" id="rolRASIC">
                            @foreach ($rolesRASIC as $item)
                                <option value="{{$item->Clave}}">{{$item->RolRASIC}}</option>
                            @endforeach
                        </select>                        
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Usuario</label>
                        <select class="form-control" name="usuario" id="usuario">
                            @foreach ($usuarios as $item)
                                <option value="{{$item->Clave}}">{{$item->Nombres}}</option>
                            @endforeach
                        </select>                        
                    </div>
                </div>                
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar<i class="fas fa-times"></i></button>
            <button type="button" class="btn btn-primary" id="update">Actualizar<i class="fas fa-edit"></i></button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var table=$('#table').DataTable();
        $('#proyecto').val('{{$rolFase->Clave_Proyecto}}');
        $('#fase').val('{{$rolFase->Clave_Fase}}');
        $('#rolRASIC').val('{{$rolFase->Clave_RolRASIC}}');
        $('#usuario').val('{{$rolFase->Clave_Usuario}}');
        $('#update').click(function(){
            
            var proyecto=$('#proyecto').val();
            var proyectoText=$('#proyecto option:selected').text();

            var fase=$('#fase').val();
            var faseText=$('#fase option:selected').text();

            var rolRASIC=$('#rolRASIC').val();
            var rolRASICText=$('#rolRASIC option:selected').text();

            var usuario=$('#usuario').val();
            var usuarioText=$('#usuario option:selected').text();


            var clave='{{ $rolFase->Clave }}';
            var token=$('#_token').val();
            var tr=  $('tr#'+clave);
            $.post('{{ url('/Admin/RolesFases/Update')}}',{_token:token,clave:clave,proyecto:proyecto,fase:fase,rolRASIC:rolRASIC,usuario:usuario},function(data ){                             
                $('#Alert').html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Listo!</strong> Se actualizó correctamente.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var data=table.row(tr)
                .data();
                data[1]=proyectoText;
                data[2]=faseText;
                data[3]=rolRASICText;
                data[4]=usuarioText;
                table
                .row( tr )
                .data( data )
                .draw();
                $('#myModal').modal('hide');
            })
            .fail(function(data) {                
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: data.responseJSON.message
                })
            });                    
        });
    });
</script>