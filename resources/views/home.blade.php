@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/mapa.css') }}">
    <script src="{{ asset('../resources/js/mapa.js') }}" defer></script>

    {{-- Google Maps API --}}
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDy0Ba3CPpNH48X3toUBGCrgQhaEvxaZks&libraries=places&callback=initMap&v=weekly"
      defer
    ></script>
@endpush

@section('content')
    {{-- Formulario vacío para recoger el action en el JS --}}
    <form action="{{ route('loc.localizaciones') }}" method="get" id="form-get-localizaciones"></form>
    <form action="{{ route('loc.liked') }}" method="get" id="form-get-liked">@csrf</form>
    <form action="{{ route('loc.likeLocalizacion') }}" method="get" id="form-store-like">@csrf</form>
    <form action="{{ route('loc.unlikeLocalizacion') }}" method="get" id="form-destroy-like">@csrf @method('DELETE')</form>

    {{-- Mapa --}}
    <div id="main-home">
        <x-navbar />
        <div id="mapa-main"></div>
        <div id="map-buttons">
            <div class="map-buttons-section">
                {{-- <i class="fa-regular fa-star"></i> --}}
                <i class="fa-regular fa-bookmark" id="mapa-fav-toggle" data-set="hidden"></i>
                {{-- <i class="fa-solid fa-arrow-right-from-bracket map-button"></i> --}}
                <i class="fa-solid fa-map-location-dot map-button" id="map-icon-button"></i>
            </div>
        </div>
    </div>

    {{-- Menu con info --}}
    <div id="menu-localizacion">
        <div id="menu-localizacion-botoncerrar-wrapper">
            <i class="fa-solid fa-xmark" id="menu-localizacion-botoncerrar"></i>
        </div>
        <div id="menu-localizacion-imagen-wrapper">
            <div id="menu-localizacion-imagen"></div>
        </div>
        <div id="menu-localizacion-datos">
            <p id="menu-localizacion-titulo"></p>
            <div class="contenedor-datos-intermedio">
                <p id="menu-localizacion-autor"></p>
                <i class="fa-regular fa-bookmark" id="menu-localizacion-botonfav"></i>
            </div>
            <p id="menu-localizacion-descripcion"></p>
            <p id="menu-localizacion-direccion"></p>
            <div id="menu-localizacion-tags"></div>
        </div>
    </div>
    @endsection