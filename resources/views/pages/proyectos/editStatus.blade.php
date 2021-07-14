<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Estado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateStatus',[$proyectoEstado['id']]) }}">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Fase</label>
                            <select name="status" class="custom-select  @error('status') is-invalid @enderror" required>
                                @php($count=0)
                                @foreach($estados as $item)
                                    @if($item->id == $OldEstado)
                                        <option selected value="{{ $item->id }}">{{ $item->estado}}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->estado }}</option>
                                    @endif                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay estados</option>
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
