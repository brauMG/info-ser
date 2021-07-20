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
                        <th scope="col" style="text-transform: uppercase">Usuario</th>
                        <th scope="col" style="text-transform: uppercase">Fase</th>
                        <th scope="col" style="text-transform: uppercase">Rol RASIC</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($rolesUser as $item)
                        <tr>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->proyecto}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->usuario}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->fase}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->rol_rasic}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
</html>
