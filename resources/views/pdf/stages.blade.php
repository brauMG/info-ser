@extends('layouts.pdf')
@section('content')
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
                        <tr id="{{$item->Clave}}">
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Proyecto}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Fase}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->Descripcion}}</td>
                            <td class="td td-center" style="font-size: 0.5em !important;">{{$item->created_at}}</td>
                            @if($date == $item->Fecha_Vencimiento)
                                @if($time > $item->Hora_Vencimiento)
                                    <td class="td td-center" style="color: red; font-size: 0.5em !important;">Vencio hoy: {{$item->Fecha_Vencimiento}}</td>
                                    <td class="td td-center" style="color: red; font-size: 0.5em !important;">Vencio hoy a las: {{$item->Hora_Vencimiento}}</td>
                                @else
                                    <td class="td td-center" style="color: black; font-size: 0.5em !important;">Vence hoy: {{$item->Fecha_Vencimiento}}</td>
                                    <td class="td td-center" style="color: black; font-size: 0.5em !important;">Vence hoy a las: {{$item->Hora_Vencimiento}}</td>
                                @endif
                            @elseif($date < $item->Fecha_Vencimiento)
                                <td class="td td-center" style="color: green; font-size: 0.5em !important;">Vence el: {{$item->Fecha_Vencimiento}}</td>
                                <td class="td td-center" style="color: green; font-size: 0.5em !important;">Vence a las: {{$item->Hora_Vencimiento}}</td>
                            @else
                                <td class="td td-center" style="color: red; font-size: 0.5em !important;">Vencio el: {{$item->Fecha_Vencimiento}}</td>
                                <td class="td td-center" style="color: red; font-size: 0.5em !important;">Vencio a las: {{$item->Hora_Vencimiento}}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
@endsection

