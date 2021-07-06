<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo RolRasic</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                 <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>Clave</label>
                        <input class="form-control" type="text" id="clave" name="clave">                        
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>RolRasic</label>
                        <input class="form-control" type="text" id="rolRASIC" name="rolRASIC">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
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
            var clave=$('#clave').val();
            var rolRASIC=$('#rolRASIC').val();
            var token=$('#_token').val();
            $.post('{{ url('/Admin/RolesRASIC/Create')}}',{_token:token,clave:clave,rolRASIC:rolRASIC},function(data ){                             
                $('#Alert').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Listo!</strong> Se agregó correctamente<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');                                              
                var node=table.rows
                .add([{ 0:clave, 1:rolRASIC, 2:'<div class="btn-group" role="group" aria-label="Basic example"><button type="button" class="btn btn-primary btn-sm edit" clave="'+clave+'" onclick="edit(this);">Editar <i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm delete" clave="'+clave+'" onclick="deleted(this);">Eliminar<i class="fas fa-trash-alt"></i></button></div>'}])
                .draw()
                .nodes();                
                $( node ).find('td').eq(2).addClass('text-right');
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