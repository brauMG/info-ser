@extends('layouts.pdf')
@section('content')
        <div class="text-center" style="margin-left: -4% !important;">
            <table class="table table-bordered">
                <thead class="table-header" style="font-size: 0.5em !important; background-color: #c6e2f5 !important; color: black !important; vertical-align: middle !important;">
                <tr>
                    <th scope="col" style="text-transform: uppercase">Proyecto</th>
                    <th scope="col" style="text-transform: uppercase">Fase</th>
                    <th scope="col" style="text-transform: uppercase">Etapa</th>
                    <th scope="col" style="text-transform: uppercase">Descripción</th>
                    <th scope="col" style="text-transform: uppercase">Decisión</th>
                    <th scope="col" style="text-transform: uppercase">Fecha de Creación</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($actividades as $item)
                    <tr id="{{$item->Clave}}">
                        <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Proyecto}}</td>
                        <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Fase}}</td>
                        <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Etapa}}</td>
                        <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Descripcion}}</td>
                        <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Decision}}
                        <td class="td td-center" style="font-size: 0.5em !important;">{{$item->FechaCreacion}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
@endsection
