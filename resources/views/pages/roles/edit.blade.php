<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Rol</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Rol</label>
                        <input class="form-control" type="text" id="rol" name="rol" value="{{$rol->Rol}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                        <input type="hidden" name="clave" value="{{$rol->Clave}}" id="clave"/>
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
        $('#update').click(function(){
            var rol=$('#rol').val();
            var clave=$('#clave').val();
            var token=$('#_token').val();
            var tr=  $('tr#'+clave);
            $.post('{{ url('/Admin/Roles/Update')}}',{_token:token,rol:rol,clave:clave},function(data ){                             
                $('#Alert').html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Listo!</strong> Se actualizo correctamente<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var info=table.row(tr).data();
                info[1]=rol                
                table
                .row( tr )
                .data( info )
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