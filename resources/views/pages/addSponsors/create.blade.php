@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
    <div class="container container-rapi2">
        <main role="main" class="ml-sm-auto">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 h2-less">Agregar Patrocinador</h1>
            </div>
        </main>
        <div id="Alert"></div>
    </div>
    @if ( session('mensaje') )
        <div class="container-edits" style="margin-top: 2%">
            <div class="alert alert-success" class='message' id='message'>{{ session('mensaje') }}</div>
        </div>
    @endif
    @if ( session('mensajeDanger') )
        <div class="container-edits" style="margin-top: 2%">
            <div class="alert alert-danger" class='message' id='message'>{{ session('mensajeDanger') }}</div>
        </div>
    @endif
    @if($errors->any())
        <div class="container-edits" style="margin-top: 1%">
            <div class="alert alert-danger" class='message' id='message'>
                Se encontraron los siguientes errores: <br>
                @foreach($errors->all() as $error)
                    <br>
                    {{'• '.$error }}
                @endforeach
            </div>
        </div>
    @endif

    <div class="container">
        <div class="card">
            <div class="card-header" style="background-color: #055e76 !important; color: white !important; text-align: center !important;">
                <h4 class="no-bottom">Patrocinador</h4>
            </div>
            <div class="card-body">
                <div class="col-xl-12" style="padding-top: 1%;">
                    <form method="POST" action="/Admin/addSponsors/create" enctype="multipart/form-data">
                        @csrf
                        <table class="table-responsive table-card-inline">

                            <tr class="tr-card-complete">
                                <th class="th-card">
                                    <i class="fas fa-wallet"></i> Nombre del patrocinador
                                </th>
                                <td class="td-card"> <input name="name" type="text"
                                                            class="form-control  @error('name') is-invalid @enderror"
                                                            placeholder="Ingresa el nombre" aria-label="name"
                                                            aria-describedby="basic-addon1" required autocomplete="name" autofocus
                                                            value={{Request::old('name')}}>
                                </td>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </tr>

                            <tr>
                                <th class="th-card">
                                    <i class="fab fa-readme"></i> Descripción sobre el patrocinador
                                </th>
                                <td class="td-card">
                                    <div class="form-group">
                                        <textarea name="description" rows="5" style="background-color: #eff0ee"
                                                  class="form-control  @error('description') is-invalid @enderror"
                                                  placeholder="Ingresa la descripción" aria-label="description"
                                                  aria-describedby="basic-addon1" required autocomplete="description" autofocus
                                                  value={{Request::old('description')}}>
                                        </textarea>
                                    </div>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>

                            <tr class="">
                                <th id='head' class="th-card"><i class="fas fa-clipboard-check"></i> Compañias Asignadas</th>
                                <td class="td-card">
                                    @foreach ($companies as $company)
                                        @if($company['Clave'] == 1)
                                            <div class="form-check">
                                                <input class="form-check-input label-size" type="hidden" name="companies[{{$company['Descripcion']}}]" value="{{ $company['Clave'] }}" checked>
                                            </div>
                                        @else
                                            <div class="form-check">
                                                <input class="form-check-input label-size" type="checkbox" name="companies[{{$company['Descripcion']}}]" value="{{ $company['Clave'] }}">
                                                <label class="form-check-label label-size" for="defaultCheck1">{{ $company['Descripcion'] }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                    @error('companies')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </td>
                            </tr>

                            <tr>
                                <th class="th-card">
                                    <i class="fas fa-link"></i> Link a su sitio WEB
                                </th>
                                <td class="td-card"> <input name="link" type="text"
                                                            class="form-control @error('description') is-invalid @enderror"
                                                            placeholder="Ingresa el link" aria-label="link"
                                                            aria-describedby="basic-addon1" required autocomplete="link" autofocus
                                                            value={{Request::old('link')}}>
                                    @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>

                            <tr>
                                <th class="th-card">
                                    <i class="far fa-file-image"></i> Imagen del patrocinador (formato .png)
                                </th>
                                <td class="td-card">
                                    <input type="file" name="image" id="file" class="adjust-file form-control @error('image') is-invalid @enderror" required />
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>

                            <tr class="">
                                <th id='head' class="th-card"><i class="fas fa-check-circle"></i> Mostrar en Inicio</th>
                                <td class="td-card">
                                    <div class="form-check">
                                        <input class="form-check-input label-size" type="checkbox" name="show" value="1">
                                        <label class="form-check-label label-size" for="defaultCheck1">Si</label>
                                    </div>
                                </td>
                            </tr>

                        </table>

                        <div class="container">
                            <button type="submit" class="button-size-08 btn btn-add btn-primary">Agregar Datos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
