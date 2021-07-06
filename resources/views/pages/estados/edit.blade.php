<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Estado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateStatusStatus',$statusId) }}">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Estado</label>
                            <input class="form-control" type="text" id="status" name="status" value="{{$status['status']}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <input type="hidden" name="clave" value="{{$status['Clave']}}" id="clave"/>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label for="compania">Compañia</label>
                            <select class="form-control" id="compania" name="company" required @if($userRol == 2) disabled @else @endif>
                                @php($count=0)
                                @foreach($company as $item)
                                    @if($item->Clave == $statusCompany)
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
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label for="compania">¿Bloquea el proyecto?</label>
                            <select class="form-control" id="activo" name="activo" required>
                                @foreach($activos as $item)
                                    @if($item == $statusActivo)
                                        <option selected value="{{$item}}">@if($item == 1) No @elseif($item == 0) Si @endif</option>
                                    @else
                                        <option value="{{$item}}">@if($item == 1) No @elseif($item == 0) Si @endif</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
            </div>
        </form>
    </div>
</div>
