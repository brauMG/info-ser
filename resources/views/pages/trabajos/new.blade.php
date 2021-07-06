<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Trabajo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Descripción</label>
                        <input class="form-control" type="text" id="descripcion" name="descripcion">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                        <div class="invalid-feedback" id="error_descripcion" style="display: none;"></div>
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
            var descripcion=$('#descripcion').val();
            var token=$('#_token').val();
            if(descripcion==""){
                $('#descripcion').addClass('is-invalid');
                $('#error_descripcion').html('*Ingresa un trabajo');
                $('#error_descripcion').show();
                error=true;
            }
            if(error==false){
                $.post('{{ url('/Admin/Trabajos/Create')}}',{_token:token,descripcion:descripcion},function(data ){
                    $('#Alert').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Listo!</strong> Se agregó correctamente.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');                                              
                    var node=table.rows
                    .add([{ 0:data.trabajo.Clave, 1:descripcion, 2:'<div class="btn-group" role="group" aria-label="Basic example"><button type="button" class="btn btn-primary btn-sm edit" clave="'+data.trabajo.Clave+'" onclick="edit(this);">Editar<i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm delete" clave="'+data.trabajo.Clave+'" onclick="deleted(this);">Eliminar<i class="fas fa-trash-alt"></i></button></div>'}])
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
            }
        });
        $('#descripcion').change(function() {
            var nombres=$('#descripcion').val();
            console.log(nombres);
            if(nombres!=""){
                if($('#descripcion').hasClass( 'is-invalid')==true){
                    $('#descripcion').removeClass('is-invalid');
                    $('#descripcion').addClass( 'is-valid');
                    $('#error_descripcion').hide();
                }
            }
        });
    });
</script>