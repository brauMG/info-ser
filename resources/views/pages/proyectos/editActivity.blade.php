<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Actividad</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateActivity', $id) }}" style="padding: 2%" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Etapas</label>
                        <select required id="etapa" type='text' class="custom-select @error('etapa') is-invalid @enderror"  name="etapa" >
                            @foreach($etapas as $etapa)
                                <option class='min' value="{{$etapa->id}}" @if($actividad->id_etapa === $etapa->id) selected @endif>{{$etapa->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descripcion</label>
                        <input type="text"
                               class="form-control @error('descripcion') is-invalid @enderror"
                               name="descripcion" value="{{$actividad->descricion}}" required
                               autocomplete="descripcion" autofocus>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Seguimiento</label>
                        <input type="text"
                               class="form-control @error('decision') is-invalid @enderror"
                               name="decision" value="{{$actividad->decision}}" required
                               autocomplete="decision" autofocus>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Evidencia (imagen u archivo)</label>
                    </div>
                    <input type="file" name="file" id="file" class="form-control"/>
                </div>
            </div>

            <div class="container mt-3" style="text-align: center">
                <button type="submit" class="btn btn-primary"><i class="material-icons">check</i>Guardar</button>
            </div>
        </form>
    </div>
</div>
