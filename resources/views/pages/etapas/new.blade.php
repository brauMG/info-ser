<div class="modal-dialog modal-lg table-form" role="document">
    <div class="modal-content" style="border: none !important;">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nueva Etapa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{route('CreateEtapa')}}" method="POST">
            @csrf
            <tr class="modal-body">
                <table class="table-responsive table-card-inline">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>

                    <tr class="tr-card-complete">
                        <div class="form-group">
                            <th class="th-card">
                                <i class="fas fa-file-signature"></i> Nombre de la Etapa
                            </th>
                            <td class="td-card">
                                <input name="descripcion" type="text"
                                       class="form-control  @error('descripcion') is-invalid @enderror"
                                       placeholder="Ingresa la descripcion" aria-label="descripcion"
                                       aria-describedby="basic-addon1" required autocomplete="descripcion" autofocus
                                       value={{Request::old('descripcion')}}>
                            </td>
                        </div>
                    </tr>

                    <tr>
                        <th for="inputGroupSelect01" class="th-card">
                            <i class="fas fa-address-card"></i> Proyecto al que pertenece
                        </th>
                        <td class="td-card"> <select name="proyecto" type="text" class="custom-select  @error('proyecto') is-invalid @enderror" required>
                                <option disabled selected>Seleccionar...</option>
                                @php($count=0)
                                @foreach($proyectos as $item)
                                    <option value="{{ $item->Clave }}">{{ $item->Descripcion }}</option>
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay proyectos</option>
                                @endif
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th class="th-card">
                            <i class="fas fa-envelope-square"></i> Fecha de Vencimiento
                        </th>
                        <td class="td-card">
                            <input name="fechaV" type="date"
                                   class="form-control  @error('fechaV') is-invalid @enderror"
                                   aria-label="fechaV"
                                   aria-describedby="basic-addon1" required autocomplete="fechaV" autofocus
                                   value={{Request::old('fechaV')}}>
                        </td>
                    </tr>

                    <tr>
                        <th class="th-card">
                            <i class="fas fa-key"></i> Hora de Vencimiento
                        </th>
                        <td class="td-card">
                            <input name="horaV" type="time"
                                   class="form-control  @error('horaV') is-invalid @enderror"
                                   aria-label="horaV"
                                   aria-describedby="basic-addon1" required autocomplete="horaV" autofocus
                                   value={{Request::old('horaV')}}>
                        </td>
                    </tr>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                </div>
        </form>
    </div>
</div>
