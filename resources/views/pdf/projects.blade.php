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
                        <tr id="{{$item->id}}">
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->descripcion}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->objetivo}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->fase}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->area}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->enfoque}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->trabajo}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->indicador}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->estado}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
</html>
