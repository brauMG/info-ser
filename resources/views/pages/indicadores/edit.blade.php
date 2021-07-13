<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Indicador</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateIndicator',$indicadorId) }}">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Indicador</label>
                            <input class="form-control" type="text" id="descripcion" name="indicador" value="{{$indicador['descripcion']}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <input type="hidden" name="clave" value="{{$indicador['id']}}" id="clave"/>
                            <div class="invalid-feedback" id="error_descripcion" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="compania">Compañia</label>
                            <select class="form-control" id="compania" name="company" required @if($userRol == 2) disabled @else @endif>
                                @php($count=0)
                                @foreach($company as $item)
                                    @if($item->id == $indicadorCompany)
                                        <option selected value="{{ $item->id }}">{{ $item->descripcion}}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="material-icons">close</i>Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="material-icons">check</i>Actualizar</button>
            </div>
        </form>
    </div>
</div>
