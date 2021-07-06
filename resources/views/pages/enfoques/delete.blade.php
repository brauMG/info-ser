<div class="modal-dialog modal-lg" role="document" aria-labelledby="exampleModalCenterTitle" id="DeleteModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #761b18">
                <h5 class="modal-title upcase"  id="exampleModalLongTitle" style="color: white">Eliminar Enfoque</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('DeleteFocus', [$enfoque['Clave']])}}" method="POST">
                @csrf
                <div style="background-color: white;color: black;">
                    <center>
                        <div class="modal-body" >
                            ¿Deseas eliminar este enfoque?
                        </div>
                        <div class="spinner-border m-5" role="status" style="display: none;">
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </center>
                </div>

                <div class="modal-footer" style="background-color: white;color: black;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>
