<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form action="{{route('CreateUser')}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input name="nombres" type="text" class="form-control  @error('nombres') is-invalid @enderror" placeholder="Ingresa tus nombres" aria-label="firstName" aria-describedby="basic-addon1" required autocomplete="nombres" autofocus value={{Request::old('nombres')}}>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Correo Electrónico</label>
                            <input name="email" type="email" class="form-control  @error('email') is-invalid @enderror" placeholder="Ingresa tu correo electrónico" aria-label="email" aria-describedby="basic-addon1" required autocomplete="email" autofocus value={{Request::old('email')}}>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input name="password" type="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Ingresa una contraseña" aria-label="password" aria-describedby="basic-addon1" required autocomplete="password" autofocus value={{Request::old('password')}}>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Confirmar Contraseña</label>
                            <input name="password_confirmation" type="password" id="password-confirm" class="form-control  @error('password-confirmation') is-invalid @enderror" placeholder="Confirma tu contraseña" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Área Asignada</label>
                            <select name="area" type="text" class="form-control  @error('area') is-invalid @enderror" required>
                                <option disabled selected>Seleccionar...</option>
                                @php($count=0)
                                @foreach($area as $item)
                                    <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                    @php($count++)
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
                                <option disabled selected>Seleccionar...</option>
                                @php($count=0)
                                @foreach($rol as $item)
                                    <option value="{{ $item->id }}">{{ $item->rol }}</option>
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay roles</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Puesto Asignado</label>
                            <select name="puesto" type="text" class="form-control  @error('puesto') is-invalid @enderror" required>
                                <option disabled selected>Seleccionar...</option>
                                @php($count=0)
                                @foreach($puesto as $item)
                                    <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay puestos</option>
                                @endif
                            </select>
                        </div>
                    </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="material-icons">close</i>Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="material-icons">check</i>Guardar</button>
            </div>
        </form>
    </div>
</div>
