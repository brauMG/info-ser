<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Fase</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateFase',$faseId) }}">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Fase</label>
                            <input class="form-control" type="text" id="descripcion" name="fase" value="{{$fase['Descripcion']}}" required>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <input type="hidden" name="clave" value="{{$fase['Clave']}}" id="clave"/>
                            <div class="invalid-feedback" id="error_descripcion" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Orden</label>
                            <input class="form-control" type="number" id="descripcion" name="orden" value="{{$fase['Orden']}}" required>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <div class="invalid-feedback" id="error_orden" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label for="compania">Compañia</label>
                            <select class="form-control" id="compania" name="company" required @if($userRol == 2) disabled @else @endif>
                                @php($count=0)
                                @foreach($company as $item)
                                    @if($item->Clave == $faseCompany)
                                        <option selected value="{{ $item->Clave }}">{{ $item->Descripcion}}</option>
                                    @else
                                        <option value="{{ $item->Clave }}">{{ $item->Descripcion }}</option>
                                    @endif
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No Hay Compañias</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</div>
