@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('Inicio')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
      <div class="col-lg-7 col-md-8">
          <h2 class="text-white text-center">{{ __('Plataforma de Asesoramiento y Planificación Financiera Personal, Familiar y de PYMES') }}</h2>
          <h1 class="text-white text-center">{{ __('SEFYX') }}</h1>
      </div>
  </div>
</div>
@endsection
