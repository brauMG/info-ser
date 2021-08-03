@inject('sponsors', 'App\Services\SponsorsInside')
@if(count($sponsors->get()->toArray()) == 0)
@else
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-bottom" style=" background-color: white !important; padding-top: 0 !important; padding-bottom: 0 !important; position: sticky !important; border-top: solid; border-top-color: #0b2f4a; border-top-width: 3px; border-bottom: solid; border-bottom-color: #0b2f4a; border-bottom-width: 3px;">
        <div class="container-fluid">
            <ul class="sponsors-ul-inside" id="c" style="display: inline-flex; flex: auto; text-align: center; margin: 10px">
                @foreach($sponsors->get() as $sponsor)
                    <li class="sponsors-li-inside" data-toggle="tooltip" data-placement="top" title="Ver información del patrocinador" style="width: 20%; display: none">
                        <img width="50" height="50" data-toggle="modal" data-target="#info{{$sponsor->id}}" src="{{ URL::to('/') }}/sponsors/{{ $sponsor->imagen }}" class="sponsors-img-inside"/>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
@endif

@foreach($sponsors->get() as $sponsor)
    <div class="modal show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" id="info{{$sponsor->id}}">
        <div class="modal-dialog padding-modal" role="document">
            <form target="_blank" action="https://{{$sponsor->enlace}}">
                <div class="modal-content"style="background-color: #ffffff;color: white;">
                    <div class="modal-header ">
                        <h5 class="modal-title"  id="exampleModalLongTitle"><img src="{{ URL::to('/') }}/sponsors/{{ $sponsor->imagen }}" width="75"/></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close" style="width: 20% !important;">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                    <div style="background-color: white;color: black;">
                        <div class="modal-body">
                            {{$sponsor->description}}
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: white;color: black;">
                        <input type="submit" class="btn-sm btn btn-primary" value="Ir a su sitio web">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

        var timer = 4000;

        var i = 0;
        var max = $('#c > li').length;

        $("#c > li").eq(i).addClass('sponsors-active');
        $("#c > li").eq(i + 1).addClass('sponsors-active');
        $("#c > li").eq(i + 2).addClass('sponsors-active');
        $("#c > li").eq(i + 3).addClass('sponsors-active');
        $("#c > li").eq(i + 4).addClass('sponsors-active');



        setInterval(function(){

            $("#c > li").removeClass('sponsors-active');

            $("#c > li").eq(i).css('transition-delay','0.25s');
            $("#c > li").eq(i + 1).css('transition-delay','0.5s');
            $("#c > li").eq(i + 2).css('transition-delay','0.75s');
            $("#c > li").eq(i + 3).css('transition-delay','1s');

            if (i < max-4) {
                i = i+4;
            }

            else {
                i = 0;
            }

            $("#c > li").eq(i).addClass('sponsors-active').css('transition-delay','1.25s');
            $("#c > li").eq(i + 1).addClass('sponsors-active').css('transition-delay','1.5s');
            $("#c > li").eq(i + 2).addClass('sponsors-active').css('transition-delay','1.75s');
            $("#c > li").eq(i + 3).addClass('sponsors-active').css('transition-delay','2s');
            $("#c > li").eq(i + 4).addClass('sponsors-active').css('transition-delay','2.25s');

        }, timer);
</script>
