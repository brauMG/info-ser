@extends('layouts.pdf')
@section('content')
            <div class="text-center">
                <table class="table table-bordered">
                    <thead class="table-header" style="font-size: 0.5em !important; background-color: #c6e2f5 !important; color: black !important; vertical-align: middle !important;">
                    <tr>
                        <th scope="col" style="text-transform: uppercase">Iniciales</th>
                        <th scope="col" style="text-transform: uppercase">Nombres</th>
                        <th scope="col" style="text-transform: uppercase">Correo</th>
                        <th scope="col" style="text-transform: uppercase">Área</th>
                        <th scope="col" style="text-transform: uppercase">Puesto</th>
                        <th scope="col" style="text-transform: uppercase">Rol</th>
                        <th scope="col" style="text-transform: uppercase">Ultima Sesión</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($usuarios as $item)
                        <tr id="{{$item->Clave}}">
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Iniciales}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Nombres}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->email}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Area}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Puesto}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Rol}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->UltimoLogin}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
@endsection
