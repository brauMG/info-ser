<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo RolFase</h5>
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
            <button type="button" class="btn btn-primary" id="save">Guardar<i class="fas fa-save"></i></button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        
        $('#save').click(function(){
            var table=$('#table').DataTable();
            
            var proyecto=$('#proyecto').val();
            var proyectoText=$('#proyecto option:selected').text();

            var fase=$('#fase').val();
            var faseText=$('#fase option:selected').text();

            var rolRASIC=$('#rolRASIC').val();
            var rolRASICText=$('#rolRASIC option:selected').text();

            var usuario=$('#usuario').val();
            var usuarioText=$('#usuario option:selected').text();

            var token=$('#_token').val();
            $.post('{{ url('/Admin/RolesFases/Create')}}',{_token:token,proyecto:proyecto,fase:fase,rolRASIC:rolRASIC,usuario:usuario},function(data ){                             
                $('#Alert').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Listo!</strong> Se agregó correctamente.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');                                              
                var node=table.rows
                .add([{ 0:data.rolFase.Clave, 1:proyectoText, 2:faseText,3:rolRASICText,4:usuarioText, 5:'<div class="btn-group" role="group" aria-label="Basic example"><button type="button" class="btn btn-primary  btn-sm edit" clave="'+data.rolFase.Clave+'" onclick="edit(this);">Editar <i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm delete" clave="'+data.rolFase.Clave+'" onclick="deleted(this);">Eliminar<i class="fas fa-trash-alt"></i></button></div>'}])
                .draw()
                .nodes();                
                $( node ).find('td').eq(5).addClass('text-right');
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