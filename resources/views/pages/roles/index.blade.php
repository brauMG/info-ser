@extends('layouts.app')
@if($compania!=null)
    @section('company',$compania->Descripcion)
@endif
@section('content')
    @include('layouts.top-nav')
    <div class="container container-rapi2">
        <main role="main" class="ml-sm-auto">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 h2-less">Roles</h1>
            </div>
        </main>
        <div id="Alert"></div>
    </div>

    <div class="container">
        <div data-simplebar class="table-responsive table-height">
            <div class="col text-center">
                <table class="table table-striped table-bordered mydatatable">
                    <thead class="table-header">
                    <tr>
                        <th scope="col" style="text-transform: uppercase">Clave</th>
                        <th scope="col" style="text-transform: uppercase">Descripción</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($rol as $item)
                            <tr id="{{$item->Clave}}">
                                <td class="td td-center">{{$item->Clave}}</td>
                                <td class="td td-center">{{$item->Rol}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-footer">
                        <tr>
                            <th style="text-transform: uppercase">Clave</th>
                            <th style="text-transform: uppercase">Descripción</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('.mydatatable').DataTable();

        function edit(button){
            var clave = $(button).attr('clave');
            $('#myModal').load( '{{ url('/Admin/Roles/Edit') }}/'+clave,function(response, status, xhr){
                if ( status == "success" ) {
                    $('#myModal').modal('show');
                }
            } );
        }
        function deleted(button){
            var clave = $(button).attr('clave');
            var tr=$(button).closest('tr');
            Swal.fire({
                title: '¿Está seguro?',
                text: "¡No podrás revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!'
            }).then(function(result){
                if (result.value) {
                    $.post('{{ url('/Admin/Roles/Delete/') }}/'+clave,{_token:'{{ csrf_token() }}'},function(data){
                        if(data.error==false){
                            table
                            .row(tr )
                            .remove()
                            .draw();
                            Swal.fire(
                                'Eliminar!',
                                'Registro eliminado.',
                                'success'
                            )
                        }
                    })
                    .fail(function(data){
                        Swal.fire({
                            type: 'error',
                            title: 'Error',
                            text: data.responseJSON.message
                        })
                    });
                }
            })
        }
        $(document).ready(function(){
            table=$('#table').DataTable({
                language:
                {
                    processing: "Cargando",
                    search: "_INPUT_",
                    searchPlaceholder: "Buscar en Registros",
                    lengthMenu: "Mostrar _MENU_ Registros",
                    info: "Registros _START_  al  _END_  de _TOTAL_",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros)",
                    oPaginate:
                        {
                            sFirst: "Primero",
                            sPrevious: "Anterior",
                            sNext: "Siguiente",
                            sLast: "Ultimo"
                        },
                    zeroRecords: "No hay registros"
                }
            });
            $('#new').click(function(){
                $('#myModal').load( '{{ url('/Admin/Roles/New') }}',function(response, status, xhr){
                    if ( status == "success" ) {
                        $('#myModal').modal('show');
                    }
                });
            });
            $('#nav-roles').addClass('active');
            $('#nav-roles').css({"background": "#9b9634","color": "white"});
        });
    </script>
@endsection
