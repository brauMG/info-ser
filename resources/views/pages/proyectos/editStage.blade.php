<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Fase</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateStage',[$proyectoFase['Clave']]) }}">
            @method('PUT')
            @csrf
            <input type="hidden" value="{{$proyectoID}}" name="id">
            <div class="modal-body">
                <tr>
                    <th for="inputGroupSelect01" class="th-card">
                        <i class="fas fa-address-card"></i> Fase
                    </th>
                    <td class="td-card"> <select name="fase" type="text" class="custom-select  @error('fase') is-invalid @enderror" required>
                            @php($count=0)
                            @foreach($fases as $item)
                                @if($item->Clave == $OldFase)
                                    <option selected value="{{ $item->Clave }}">{{ $item->Descripcion}}</option>
                                @else
                                    <option value="{{ $item->Clave }}">{{ $item->Descripcion }}</option>
                                @endif                                    @php($count++)
                            @endforeach
                            @if($count ==0)
                                <option disabled selected>No hay fases</option>
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
