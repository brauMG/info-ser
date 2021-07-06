<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Estado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateSend',[$userSend['Clave']]) }}">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <tr>
                    <th for="inputGroupSelect01" class="th-card">
                        <i class="fas fa-address-card"></i> Estado
                    </th>
                    <td class="td-card"> <select name="send" type="text" class="custom-select  @error('send') is-invalid @enderror" required>
                            <option @if($OldUser == true) selected @endif value="1">Enviar</option>
                            <option @if($OldUser == false) selected @endif value="0">No enviar</option>
                        </select>
                    </td>
                </tr>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
            </div>
        </form>
    </div>
</div>
