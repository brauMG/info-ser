<div class="modal-dialog modal-lg table-form" role="document">
    <div class="modal-content" style="border: none !important;">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Actualizar Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form" id="from" method="POST" action="{{ route('UpdateUser',$userId) }}">
            @method('PUT')
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
                                       value="{{$usuario['Nombres']}}">
                            </td>
                        </div>
                    </tr>

                    <tr>
                        <th class="th-card">
                            <i class="fas fa-envelope-square"></i> Correo Electrónico
                        </th>
                        <td class="td-card">
                            <input name="email" type="email"
                                   class="form-control  @error('correo') is-invalid @enderror"
                                   placeholder="Ingresa tu correo electrónico" aria-label="email"
                                   aria-describedby="basic-addon1" required autocomplete="email" autofocus
                                   value={{$usuario['email']}}>
                        </td>
                    </tr>

                    <tr>
                        <th for="inputGroupSelect01" class="th-card">
                            <i class="fas fa-address-card"></i> Área Asignada
                        </th>
                        <td class="td-card"> <select name="area" type="text" class="custom-select  @error('area') is-invalid @enderror" required>
                                @php($count=0)
                                @foreach($area as $item)
                                    @if($item->Clave == $usuarioArea)
                                        <option selected value="{{ $item->Clave }}">{{ $item->Descripcion}}</option>
                                    @else
                                        <option value="{{ $item->Clave }}">{{ $item->Descripcion }}</option>
                                    @endif                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay áreas</option>
                                @endif
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th for="inputGroupSelect01" class="th-card">
                            <i class="fas fa-address-card"></i> Rol Asignado
                        </th>
                        <td class="td-card"> <select name="rol" type="text" class="custom-select  @error('rol') is-invalid @enderror" required>
                                @php($count=0)
                                @foreach($rol as $item)
                                    @if($item->Clave == $usuarioRol)
                                        <option selected value="{{ $item->Clave }}">{{ $item->Rol}}</option>
                                    @else
                                        <option value="{{ $item->Clave }}">{{ $item->Rol }}</option>
                                    @endif
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
                                @php($count=0)
                                @foreach($puesto as $item)
                                    @if($item->Clave == $usuarioPuesto)
                                        <option selected value="{{ $item->Clave }}">{{ $item->Puesto }}</option>
                                    @else
                                        <option value="{{ $item->Clave }}">{{ $item->Puesto }}</option>
                                    @endif
                                    @php($count++)
                                @endforeach
                                @if($count ==0)
                                    <option disabled selected>No hay puestos</option>
                                @endif
                            </select>
                        </td>
                    </tr>
                </table>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
            </div>
        </form>
    </div>
</div>
