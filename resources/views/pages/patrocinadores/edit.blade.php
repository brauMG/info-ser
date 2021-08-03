<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar Patrocinador</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form action="{{route('UpdateSponsor', $sponsor)}}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input name="name" type="text"
                                   class="form-control  @error('name') is-invalid @enderror"
                                   placeholder="Ingresa el nombre" aria-label="name"
                                   aria-describedby="basic-addon1" required autocomplete="name" autofocus
                                   value={{$sponsor->nombre}}>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                            <div class="invalid-feedback" id="error_name" style="display: none;"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea name="description" rows="5" style="background-color: #eff0ee"
                                      class="form-control  @error('description') is-invalid @enderror"
                                      placeholder="Ingresa la descripción" aria-label="description"
                                      aria-describedby="basic-addon1" required autocomplete="description" autofocus>{{$sponsor->description}}
                            </textarea>
                            <div class="invalid-feedback" id="error_name" style="display: none;"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Compañias Asignadas</label>
                            <select id="companies" class="form-control" multiple="multiple" name="companies[]">
                                @foreach($array_companies as $company)
                                    <option value="{{$company['id_compania']}}" @if($company['valid'] == true) selected @else @endif>{{$company['name']}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="error_name" style="display: none;"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Enlace a sitio WEB</label>
                            <input name="link" type="text"
                                   class="form-control @error('link') is-invalid @enderror"
                                   placeholder="Ingresa el link" aria-label="link"
                                   aria-describedby="basic-addon1" required autocomplete="link" autofocus
                                   value={{$sponsor->enlace}}>
                            <div class="invalid-feedback" id="error_name" style="display: none;"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Imagen del patrocinador (formato .png)</label>
                        </div>
                        <input type="file" name="image" id="file" class="form-control"/>
                        <input type="hidden" name="hidden_image" value="{{ $sponsor->imagen }}" />
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="material-icons">close</i>Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="material-icons">check</i>Guardar</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(function(){
        $('#companies').multiselect();
    });
</script>
