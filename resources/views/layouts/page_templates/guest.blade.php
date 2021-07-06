@include('layouts.navbars.navs.guest')
<div class="wrapper wrapper-full-page canvas-login">
    <video autoplay muted loop src="{{ asset('videos') }}/lines.mp4" class="background-video"></video>
    <div class="page-header login-page header-filter" filter-color="black" style="align-items: center;" data-color="purple">
  <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
    @yield('content')
    @include('layouts.footers.guest')
  </div>
</div>
