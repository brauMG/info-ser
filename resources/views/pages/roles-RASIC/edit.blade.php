<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar RolRASIC</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>Clave</label> 
                        <input name="clave" value="{{$rolRASIC->Clave}}" id="clave" class="form-control"/>
                        <input name="old_clave" value="{{$rolRASIC->Clave}}" id="old_clave" type="hidden"/>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>RolRASIC</label>                        
                        <input class="form-control" type="text" id="rolRASIC" name="rolRASIC" value="{{$rolRASIC->RolRASIC}}">                        
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
            var rolRASIC=$('#rolRASIC').val();
            var clave=$('#clave').val();
            var old_clave=$('#old_clave').val();
            var token=$('#_token').val();
            var tr=  $('tr#'+old_clave);
            $.post('{{ url('/Admin/RolesRASIC/Update')}}',{_token:token,rolRASIC:rolRASIC,clave:clave,old_clave:old_clave},function(data ){                             
                $('#Alert').html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Listo!</strong> Se actualizó correctamente.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var data=table.row(tr)
                .data();
                data[0]=clave;
                data[1]=rolRASIC;
                table
                .row( tr )
                .data( data )
                .draw();
                $('tr#'+old_clave).attr('id',clave);
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