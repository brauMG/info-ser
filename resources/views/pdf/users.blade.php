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
                        <tr id="{{$item->id}}">
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->iniciales}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->nombres}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->email}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->area}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->puesto}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->rol}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->ultima_sesion}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
</html>
