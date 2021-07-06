<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Rol</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Rol</label>
                        <input class="form-control" type="text" id="rol" name="rol">
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
        var table=$('#table').DataTable();
        $('#save').click(function(){
            var rol=$('#rol').val();
            var token=$('#_token').val();
            $.post('{{ url('/Admin/Roles/Create')}}',{_token:token,rol:rol},function(data ){                             
                $('#Alert').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Listo!</strong> Se agregó correctamente.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var node=table.rows
                .add( [{0:data.rol.Clave,1:rol,2:'<div class="btn-group" role="group" aria-label="Basic example"><button type="button" class="btn btn-primary edit" clave="'+data.rol.Clave+'" onclick="edit(this);">Editar <i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger delete" clave="'+data.rol.Clave+'" onclick="deleted(this);">Eliminar<i class="fas fa-trash-alt"></i></button></div>'}])
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