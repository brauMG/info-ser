@extends('layouts.pdf')
@section('content')
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
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Proyecto}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Usuario}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Fase}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->RolRASIC}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
@endsection
