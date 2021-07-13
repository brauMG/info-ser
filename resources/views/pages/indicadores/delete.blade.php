<div class="modal-dialog modal-lg" role="document" aria-labelledby="exampleModalCenterTitle" id="DeleteModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title upcase"  id="exampleModalLongTitle" style="color: white">Eliminar Indicador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <i class="material-icons">close</i>
                </button>
            </div>
            <form action="{{route('DeleteIndicator', [$indicador['id']])}}" method="POST">
                @csrf
                <div style="background-color: white;color: black;">
                    <center>
                        <div class="modal-body" >
                            ¿Deseas eliminar este indicador?
                        </div>
                        <div class="spinner-border m-5" role="status" style="display: none;">
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </center>
                </div>

                <div class="modal-footer" style="background-color: white;color: black;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="material-icons">close</i>Cerrar</button>
                    <button type="submit" class="btn btn-danger"><i class="material-icons">delete</i>Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
