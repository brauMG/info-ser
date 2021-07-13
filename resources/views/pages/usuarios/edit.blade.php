<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateUser',$userId) }}">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input name="nombres" type="text"
                                   class="form-control  @error('nombres') is-invalid @enderror"
                                   placeholder="Ingresa tus nombres" aria-label="firstName"
                                   aria-describedby="basic-addon1" required autocomplete="nombres" autofocus
                                   value="{{$usuario['nombres']}}">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Correo Electrónico</label>
                            <input name="email" type="email"
                                   class="form-control  @error('correo') is-invalid @enderror"
                                   placeholder="Ingresa tu correo electrónico" aria-label="email"
                                   aria-describedby="basic-addon1" required autocomplete="email" autofocus
                                   value={{$usuario['email']}}>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Área Asignada</label>
                            <select name="area" type="text" class="form-control @error('area') is-invalid @enderror" required>
                                @php($count=0)
                                @foreach($area as $item)
                                    @if($item->id == $usuarioArea)
                                        <option selected value="{{ $item->id }}">{{ $item->descripcion}}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                    @endif                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay áreas</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Rol Asignado</label>
                            <select name="rol" type="text" class="form-control  @error('rol') is-invalid @enderror" required>
                                @php($count=0)
                                @foreach($rol as $item)
                                    @if($item->id == $usuarioRol)
                                        <option selected value="{{ $item->id }}">{{ $item->rol}}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->rol }}</option>
                                    @endif
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No Hay Roles</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Puesto Asignado</label>
                            <select name="puesto" type="text" class="form-control  @error('puesto') is-invalid @enderror" required>
                                @php($count=0)
                                @foreach($puesto as $item)
                                    @if($item->id == $usuarioPuesto)
                                        <option selected value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                    @endif
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay puestos</option>
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
