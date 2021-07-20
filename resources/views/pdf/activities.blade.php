<!doctype html>
<html>
<head>
    <title>Sistema de Enfoque Rapido</title>
    <!-- Styles -->
    <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
</head>
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
            <tr id="{{$item->id}}">
                <td class="td td-center" style="font-size: 0.5em !important;">{{$item->proyecto}}</td>
                <td class="td td-center" style="font-size: 0.5em !important;">{{$item->fase}}</td>
                <td class="td td-center" style="font-size: 0.5em !important;">{{$item->etapa}}</td>
                <td class="td td-center" style="font-size: 0.5em !important;">{{$item->descricion}}</td>
                <td class="td td-center" style="font-size: 0.5em !important;">{{$item->decision}}
                <td class="td td-center" style="font-size: 0.5em !important;">{{$item->fecha_creacion}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</html>
