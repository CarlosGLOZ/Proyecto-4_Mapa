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

    {{-- Mapa --}}
    <div id="main-home">
        <x-navbar />
        <div id="mapa-main"></div>
        <div id="map-buttons">
            <div class="map-buttons-section">
                <i class="fa-regular fa-star"></i>
            </div>
            <div class="map-buttons-section">
                <i class="fa-solid fa-arrow-right-from-bracket map-button"></i>
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
            <img src="" id="menu-localizacion-imagen">
        </div>
        <div id="menu-localizacion-datos">
            <p id="menu-localizacion-titulo"></p>
            <p id="menu-localizacion-autor"></p>
            <p id="menu-localizacion-descripcion"></p>
            <p id="menu-localizacion-direccion"></p>
            <div id="menu-localizacion-tags"></div>
        </div>
        <div id="menu-localizacion-botones">
            <button class="standard-button" id="menu-localizacion-botonfav"></button>
        </div>
    </div>
    @endsection