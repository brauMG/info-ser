{{--@inject('areas', 'App\Services\Area')--}}
<div class="modal-dialog modal-lg table-form" role="document">
    <div class="modal-content" style="border: none !important;">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Proyecto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
{{--        <div id="app">--}}
            <form action="{{route('CreateProject')}}" method="POST">
                @csrf
                <tr class="modal-body">
                    <table class="table-responsive table-card-inline">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>

                        <tr class="tr-card-complete">
                            <div class="form-group">
                                <th class="th-card">
                                    <i class="fas fa-file-signature"></i> Descripción
                                </th>
                                <td class="td-card">
                                    <input name="descripcion" type="text"
                                           class="form-control  @error('descripcion') is-invalid @enderror"
                                           placeholder="Ingresa la descripción del proyecto (Nombre)" aria-label="descripcion"
                                           aria-describedby="basic-addon1" required autocomplete="nombres" autofocus
                                           value={{Request::old('nombres')}}>
                                </td>
                            </div>
                        </tr>

                        <tr class="tr-card-complete">
                            <div class="form-group">
                                <th class="th-card">
                                    <i class="fas fa-file-signature"></i> Objetivo
                                </th>
                                <td class="td-card">
                                    <input name="objetivo" type="text"
                                           class="form-control  @error('objetivo') is-invalid @enderror"
                                           placeholder="Ingresa el objetivo del proyecto" aria-label="firstName"
                                           aria-describedby="basic-addon1" required autocomplete="objetivo" autofocus
                                           value={{Request::old('objetivo')}}>
                                </td>
                            </div>
                        </tr>

                        <tr class="tr-card-complete">
                            <div class="form-group">
                                <th class="th-card">
                                    <i class="fas fa-file"></i> Criterio de Exito
                                </th>
                                <td class="td-card">
                                    <input name="criterio" type="text"
                                           class="form-control  @error('criterio') is-invalid @enderror"
                                           placeholder="Ingresa el criterio de exito del proyecto" aria-label="criterio"
                                           aria-describedby="basic-addon1" required autocomplete="criterio" autofocus
                                           value={{Request::old('criterio')}}>
                                </td>
                            </div>
                        </tr>

                        <tr>
                            <th for="inputGroupSelect01" class="th-card">
                                <i class="fas fa-address-card"></i> Área
                            </th>
                            <td class="td-card"> <select name="area" type="text" class="custom-select  @error('area') is-invalid @enderror" required>
                                    <option disabled selected>Seleccionar</option>
                                    @php($count=0)
                                    @foreach($areas as $item)
                                        <option value="{{ $item->Clave }}">{{ $item->Descripcion}}</option>
                                        @php($count++)
                                    @endforeach
                                    @if($count ==0)
                                        <option disabled selected>No hay áreas</option>
                                    @endif
                                </select>
                            </td>
                        </tr>

{{--                        <tr>--}}
{{--                            <th for="inputGroupSelect01" class="th-card">--}}
{{--                                <i class="fas fa-address-card"></i> Área--}}
{{--                            </th>--}}
{{--                            <td class="td-card">--}}
{{--                                <select v-model="selected_area" @change="loadUsers" data-old="{{ old('area') }}"  type='text' required id="area" class="custom-select @error('area') is-invalid @enderror" name="area">--}}
{{--                                    @foreach($areas->get() as $index => $area)--}}
{{--                                        <option value="{{ $index }}">--}}
{{--                                            {{ $area }}--}}
{{--                                        </option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @error('area')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                @enderror--}}
{{--                            </td>--}}
{{--                        </tr>--}}

{{--                        <tr>--}}
{{--                            <th for="inputGroupSelect01" class="th-card">--}}
{{--                                <i class="fas fa-address-card"></i> Usuarios--}}
{{--                            </th>--}}
{{--                            <td class="td-card">--}}
{{--                                <select v-model="selected_user" data-old="{{ old('user') }}"  type='text' required id="user" class="custom-select @error('usuario') is-invalid @enderror" name="usuario">--}}
{{--                                    <option value="">Selecciona un usuario</option>--}}
{{--                                    <option v-for="(user, index) in users" v-bind:value="index">--}}
{{--                                        @{{user}}--}}
{{--                                    </option>>--}}
{{--                                </select>--}}
{{--                                @error('usuario')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                @enderror--}}
{{--                            </td>--}}
{{--                        </tr>--}}

{{--                        <tr>--}}
{{--                            <th for="inputGroupSelect01" class="th-card">--}}
{{--                                <i class="fas fa-address-card"></i> RASIC--}}
{{--                            </th>--}}
{{--                            <td class="td-card"> <select name="rasic" type="text" class="custom-select  @error('rasic') is-invalid @enderror" required>--}}
{{--                                    <option disabled selected>Seleccionar</option>--}}
{{--                                    @foreach($rasic as $item)--}}
{{--                                        <option value="{{ $item->Clave }}">{{ $item->RolRASIC }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </td>--}}
{{--                        </tr>--}}

                        <tr>
                            <th for="inputGroupSelect01" class="th-card">
                                <i class="fas fa-address-card"></i> Fase
                            </th>
                            <td class="td-card"> <select name="fase" type="text" class="custom-select  @error('fase') is-invalid @enderror" required>
                                    <option disabled selected>Seleccionar</option>
                                    @php($count=0)
                                    @foreach($fases as $item)
                                        <option value="{{ $item->Clave }}">{{ $item->Descripcion }}</option>
                                        @php($count++)
                                    @endforeach
                                    @if($count ==0)
                                        <option disabled selected>No hay fases</option>
                                    @endif
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th for="inputGroupSelect01" class="th-card">
                                <i class="fas fa-address-card"></i> Enfoque
                            </th>
                            <td class="td-card"> <select name="enfoque" type="text" class="custom-select  @error('enfoque') is-invalid @enderror" required>
                                    <option disabled selected>Seleccionar</option>
                                    @php($count=0)
                                    @foreach($enfoques as $item)
                                        <option value="{{ $item->Clave }}">{{ $item->Descripcion }}</option>
                                        @php($count++)
                                    @endforeach
                                    @if($count ==0)
                                        <option disabled selected>No hay enfoques</option>
                                    @endif
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th for="inputGroupSelect01" class="th-card">
                                <i class="fas fa-address-card"></i> Trabajo
                            </th>
                            <td class="td-card"> <select name="trabajo" type="text" class="custom-select  @error('trabajo') is-invalid @enderror" required>
                                    <option disabled selected>Seleccionar</option>
                                    @php($count=0)
                                    @foreach($trabajos as $item)
                                        <option value="{{ $item->Clave }}">{{ $item->Descripcion }}</option>
                                        @php($count++)
                                    @endforeach
                                    @if($count ==0)
                                        <option disabled selected>No hay trabajos</option>
                                    @endif
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th for="inputGroupSelect01" class="th-card">
                                <i class="fas fa-address-card"></i> Indicador
                            </th>
                            <td class="td-card"> <select name="indicador" type="text" class="custom-select  @error('indicador') is-invalid @enderror" required>
                                    <option disabled selected>Seleccionar</option>
                                    @php($count=0)
                                    @foreach($indicadores as $item)
                                        <option value="{{ $item->Clave }}">{{ $item->Descripcion }}</option>
                                        @php($count++)
                                    @endforeach
                                    @if($count ==0)
                                        <option disabled selected>No hay indicadores</option>
                                    @endif
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th for="inputGroupSelect01" class="th-card">
                                <i class="fas fa-address-card"></i> Estado Inicial del Proyecto
                            </th>
                            <td class="td-card"> <select name="estado" type="text" class="custom-select  @error('estado') is-invalid @enderror" required>
                                    <option disabled selected>Seleccionar</option>
                                    @php($count=0)
                                    @foreach($estados as $item)
                                        <option value="{{ $item->Clave }}">{{ $item->status }}</option>
                                        @php($count++)
                                    @endforeach
                                    @if($count ==0)
                                        <option disabled selected>No hay estados</option>
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
{{--        </div>--}}
    </div>
</div>
