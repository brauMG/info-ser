<nav class="navbar fixed-top flex-md-nowrap p-0 shadow" style="background-color:#16a5b8;color:black;">

    <a class="col-6 navbar-brand col-sm-3 col-md-2 mr-0" href="#" style="color:white;">Sistema de Enfoque Rapido</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" id="navbar-toggler-button" onclick="toggleMenu()">

      <span class="fas fa-bars navbar-toggler-icon"></span>
    </button>
    <div class="col-12 col-md-10">
      <div class="row">
        <div class="col-4 col-md-4">
          @php
            $nombres = explode(" ",  Auth::user()->Nombres);
          @endphp
          <a class="nav-link" href="#" style="color:white;">{{ $nombres[0] }}@if(count($nombres)>1) {{' '.$nombres[1]}} @endif</a>
        </div>

        <div class="col-4 col-md-4 text-center">
          <div class="form-inline text-center">
            <a class="btn btn-link" href="#" style="color:white;" @if(Auth::user()->Clave_Rol=='1') onclick="ChangeCompany();" @endif>
              @yield('company','Sin Compañia')
            </a>

          </div>
        </div>

          <div class="col-4 col-md-4 text-right">
            @if(Auth::check())
                <a class="nav-link" href="{{route('logout')}}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color:white;">Cerrar Sesión</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              @else
                <a class="nav-link" href="{{route('login')}}" style="color:white;">Iniciar sesión</a>
              @endif
          </div>
      </div>

    </div>
  </nav>
  <script type="text/javascript">
    function toggleMenu(){
      $('#sidebar-left').toggleClass('col-md-2');
    }
    function ChangeCompany(){
      $('#myModal').load( '{{ url('/home/selectCompany') }}',function(response, status, xhr){
        if ( status == "success" ) {
          $('#myModal').modal('show');
        }else{
          Swal.fire({
            type: 'Error',
            title: 'Error',
            text: 'Hubo un error al cargar la vista'
          })
        }
      });

    }
  </script>
