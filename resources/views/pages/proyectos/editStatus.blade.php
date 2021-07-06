<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Estado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateStatus',[$proyectoEstado['Clave']]) }}">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <tr>
                    <th for="inputGroupSelect01" class="th-card">
                        <i class="fas fa-address-card"></i> Estado
                    </th>
                    <td class="td-card"> <select name="status" type="text" class="custom-select  @error('status') is-invalid @enderror" required>
                            @php($count=0)
                            @foreach($estados as $item)
                                @if($item->Clave == $OldEstado)
                                    <option selected value="{{ $item->Clave }}">{{ $item->status}}</option>
                                @else
                                    <option value="{{ $item->Clave }}">{{ $item->status }}</option>
                                @endif                                    @php($count++)
                            @endforeach
                            @if($count ==0)
                                <option disabled selected>No hay estados</option>
                            @endif
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
