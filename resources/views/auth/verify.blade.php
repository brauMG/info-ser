@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('INFO SER')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
      <div class="col-lg-7 col-md-8">
          <div class="card card-login card-hidden mb-3">
            <div class="card-header card-header-primary text-center card-head-color">
              <p class="card-title"><strong>{{ __('Verificar tu dirección de correo electrónico') }}</strong></p>
            </div>
            <div class="card-body">
              <p class="card-description text-center"></p>
              <p>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('Un nuevo enlace de verificación fue enviado a tu correo electrónico.') }}
                    </div>
                @endif

                {{ __('Antes de proceder, por favor verifica el enlace que enviamos a tu correo.') }}

                @if (Route::has('verification.resend'))
                    {{ __('Si no recibiste ningun correo') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('presiona aquí para solicitar otro') }}</button>.
                    </form>
                @endif
              </p>
            </div>
          </div>
      </div>
  </div>
</div>
@endsection
