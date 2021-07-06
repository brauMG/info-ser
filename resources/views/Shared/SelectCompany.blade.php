<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Seleciona compañia</h5>
        </div>
        <div class="modal-body">
        	<div class="row">
        		<div class="col-12 col-md-6">
        			<label>Compañia</label>
        			<select class="form-control" id="company">
                            @php($count=0)
                            @foreach($companias as $item)
                                @if($item->Clave == $userCompany)
                                    <option selected value="{{ $item->Clave }}">{{ $item->Descripcion}}</option>
                                @else
                                    <option value="{{ $item->Clave }}">{{ $item->Descripcion }}</option>
                                @endif
                                @php($count++)
                            @endforeach
                            @if($count ==0)
                                <option disabled selected>No Hay Compañias</option>
                            @endif
        			</select>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
        		</div>
        	</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save">Selecciona compañia</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#save').click(function(){
            var company=$('#company').val();
            var token=$('#_token').val();
            $.get('{{ url('/Admin/Usuarios/ChangeCompany')}}/'+company,{_token:token},function(data ){
                location.reload();
            });
        });

    });
</script>
