<div class="modal-dialog modal-lg table-form" role="document">
    <div class="modal-content" style="border: none !important;">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{route('CreateUser')}}" method="POST">
            @csrf
            <tr class="modal-body">
                <table class="table-responsive table-card-inline">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>

                    <tr class="tr-card-complete">
                        <div class="form-group">
                            <th class="th-card">
                                <i class="fas fa-file-signature"></i> Nombres
                            </th>
                            <td class="td-card">
                                <input name="nombres" type="text"
                                       class="form-control  @error('nombres') is-invalid @enderror"
                                       placeholder="Ingresa tus nombres" aria-label="firstName"
                                       aria-describedby="basic-addon1" required autocomplete="nombres" autofocus
                                       value={{Request::old('nombres')}}>
                            </td>
                        </div>
                    </tr>

                    <tr>
                        <th class="th-card">
                            <i class="fas fa-envelope-square"></i> Correo Electrónico
                        </th>
                        <td class="td-card">
                            <input name="email" type="email"
                                   class="form-control  @error('email') is-invalid @enderror"
                                   placeholder="Ingresa tu correo electrónico" aria-label="email"
                                   aria-describedby="basic-addon1" required autocomplete="email" autofocus
                                   value={{Request::old('email')}}>
                        </td>
                    </tr>

                    <tr>
                        <th class="th-card">
                            <i class="fas fa-key"></i> Contraseña
                        </th>
                        <td class="td-card">
                            <input name="password" type="password"
                                   class="form-control  @error('password') is-invalid @enderror"
                                   placeholder="Ingresa una contraseña" aria-label="password"
                                   aria-describedby="basic-addon1" required autocomplete="password" autofocus
                                   value={{Request::old('password')}}>
                        </td>
                    </tr>

                    <tr>
                        <th class="th-card">
                            <i class="fas fa-lock"></i> Confirmar Contraseña
                        </th>
                        <td class="td-card">
                            <input name="password_confirmation" type="password" id="password-confirm"
                                   class="form-control  @error('password-confirmation') is-invalid @enderror"
                                   placeholder="Confirma tu contraseña" required autocomplete="new-password">
                        </td>
                    </tr>

                    <tr>
                        <th for="inputGroupSelect01" class="th-card">
                            <i class="fas fa-address-card"></i> Área Asignada
                        </th>
                        <td class="td-card"> <select name="area" type="text" class="custom-select  @error('area') is-invalid @enderror" required>
                                <option disabled selected>Seleccionar...</option>
                                @php($count=0)
                                @foreach($area as $item)
                                        <option value="{{ $item->Clave }}">{{ $item->Descripcion }}</option>
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No Hay Áreas</option>
                                @endif
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th for="inputGroupSelect01" class="th-card">
                            <i class="fas fa-address-card"></i> Rol Asignado
                        </th>
                        <td class="td-card"> <select name="rol" type="text" class="custom-select  @error('rol') is-invalid @enderror" required>
                                <option disabled selected>Seleccionar...</option>
                                @php($count=0)
                                @foreach($rol as $item)
                                    <option value="{{ $item->Clave }}">{{ $item->Rol }}</option>
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No Hay Roles</option>
                                @endif
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th for="inputGroupSelect01" class="th-card">
                            <i class="fas fa-address-card"></i> Puesto Asignado
                        </th>
                        <td class="td-card"> <select name="puesto" type="text" class="custom-select  @error('puesto') is-invalid @enderror" required>
                                <option disabled selected>Seleccionar...</option>
                                @php($count=0)
                                @foreach($puesto as $item)
                                    <option value="{{ $item->Clave }}">{{ $item->Puesto }}</option>
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No Hay Puestos</option>
                                @endif
                            </select>
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
