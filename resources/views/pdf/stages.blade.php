<!doctype html>
<html>
<head>
    <title>Sistema de Enfoque Rapido</title>
    <!-- Styles -->
    <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
</head>
            <div class="text-center">
                <table class="table table-bordered">
                    <thead class="table-header" style="font-size: 0.5em !important; background-color: #c6e2f5 !important; color: black !important; vertical-align: middle !important;">
                    <tr>
                        <th scope="col" style="text-transform: uppercase">Proyecto</th>
                        <th scope="col" style="text-transform: uppercase">Fase</th>
                        <th scope="col" style="text-transform: uppercase">Etapa</th>
                        <th scope="col" style="text-transform: uppercase">Fecha de Creación</th>
                        <th scope="col" style="text-transform: uppercase">Fecha de Vencimiento</th>
                        <th scope="col" style="text-transform: uppercase">Hora de Vencimiento</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($etapas as $item)
                        <tr id="{{$item->id}}">
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->proyecto}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->fase}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->descripcion}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->created_at}}</td>
                            @if($date == $item->fecha_vencimiento)
                                @if($time > $item->hora_vencimiento)
                                    <td class="td td-center" style="color: red; font-size: 0.5em !important;">Vencio hoy: {{$item->fecha_vencimiento}}</td>
                                    <td class="td td-center" style="color: red; font-size: 0.5em !important;">Vencio hoy a las: {{$item->hora_vencimiento}}</td>
                                @else
                                    <td class="td td-center" style="color: black; font-size: 0.5em !important;">Vence hoy: {{$item->fecha_vencimiento}}</td>
                                    <td class="td td-center" style="color: black; font-size: 0.5em !important;">Vence hoy a las: {{$item->hora_vencimiento}}</td>
                                @endif
                            @elseif($date < $item->fecha_vencimiento)
                                <td class="td td-center" style="color: green; font-size: 0.5em !important;">Vence el: {{$item->fecha_vencimiento}}</td>
                                <td class="td td-center" style="color: green; font-size: 0.5em !important;">Vence a las: {{$item->hora_vencimiento}}</td>
                            @else
                                <td class="td td-center" style="color: red; font-size: 0.5em !important;">Vencio el: {{$item->fecha_vencimiento}}</td>
                                <td class="td td-center" style="color: red; font-size: 0.5em !important;">Vencio a las: {{$item->hora_vencimiento}}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
</html>

