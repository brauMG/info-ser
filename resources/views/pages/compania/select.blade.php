<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">Selecciona Compañia</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Compañia</label>
                        <select class="form-control" id="company">
                            @php($count=0)
                            @foreach($companias as $item)
                                @if($item->id == $userCompany)
                                    <option selected value="{{ $item->id }}">{{ $item->descripcion}}</option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                @endif
                                @php($count++)
                            @endforeach
                            @if($count ==0)
                                <option disabled selected>No hay compañias</option>
                            @endif
                        </select>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="material-icons">close</i>Cerrar</button>
            <button type="button" class="btn btn-primary" id="save"><i class="material-icons">check</i>Cambiar</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#save').click(function(){
            var company=$('#company').val();
            var token=$('#_token').val();
            $.get('{{ url('/companias/change-company')}}/'+company,{_token:token},function(data ){
                location.reload();
            });
        });
    });
</script>
