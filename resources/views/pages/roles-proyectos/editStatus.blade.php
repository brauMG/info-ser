<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Estado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateStatusProjectUser',[$rolProyectoEstado['Clave']]) }}">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <tr>
                    <th for="inputGroupSelect01" class="th-card">
                        <i class="fas fa-address-card"></i> Estado del usuario en el proyecto
                    </th>
                    <td class="td-card"> <select name="status" type="text" class="custom-select  @error('status') is-invalid @enderror" required>
                            @foreach($estados as $item)
                                @if($item == 1)
                                    <option selected value="{{$item}}">Activo</option>
                                @elseif($item == 2)
                                    <option value="{{$item}}">Inactivo</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                </tr>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
            </div>
        </form>
    </div>
</div>
