@extends('layouts.pdf')
@section('content')
            <div class="text-center">
                <table class="table table-bordered">
                    <thead class="table-header" style="font-size: 0.5em !important; background-color: #c6e2f5 !important; color: black !important; vertical-align: middle !important;">
                    <tr>
                        <th scope="col" style="text-transform: uppercase">Proyecto</th>
                        <th scope="col" style="text-transform: uppercase">Objetivo</th>
                        <th scope="col" style="text-transform: uppercase">Fase</th>
                        <th scope="col" style="text-transform: uppercase">Area</th>
                        <th scope="col" style="text-transform: uppercase">Enfoque</th>
                        <th scope="col" style="text-transform: uppercase">Trabajo</th>
                        <th scope="col" style="text-transform: uppercase">Indicador</th>
                        <th scope="col" style="text-transform: uppercase">Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($proyectos as $item)
                        <tr id="{{$item->Clave}}">
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Descripcion}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Objectivo}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Fase}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Area}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Enfoque}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Trabajo}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Indicador}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Estado}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
@endsection
