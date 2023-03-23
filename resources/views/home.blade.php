@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/mapa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menuPrincipal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menuLocalizacion.css') }}">
    <script src="{{ asset('../resources/js/mapa.js') }}" defer></script>
    <script src="{{ asset('../resources/js/menu.js') }}" defer></script>

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
                @auth
                    <i class="fa-regular fa-bookmark" id="mapa-fav-toggle" data-set="hidden"></i>
                @else
                    <a href="{{ route('auth.LoginRegistrar') }}" style="color: black;"><i class="fa-solid fa-right-to-bracket"></i></a>
                @endauth
                {{-- <i class="fa-solid fa-arrow-right-from-bracket map-button"></i> --}}
                <i class="fa-solid fa-bars map-button" id="menu-button"></i>
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

    {{-- Menu con para guardar un punto --}}
    <div id="menu-localizacion-crear">
        <input type="hidden" name="latitud" id="menu-localizacion-crear-input-latitud">
        <input type="hidden" name="longitud" id="menu-localizacion-crear-input-longitud">
        <div id="menu-localizacion-crear-botoncerrar-wrapper">
            <i class="fa-solid fa-xmark" id="menu-localizacion-crear-botoncerrar"></i>
        </div>
        <div id="menu-localizacion-crear-imagen-wrapper">
            <div id="menu-localizacion-crear-imagen"></div>
        </div>
        <div id="menu-localizacion-crear-datos">
            <input type="text" name="nombre" id="menu-localizacion-crear-titulo" placeholder="Nombre" required>
            <div class="contenedor-datos-intermedio">
                <p id="menu-localizacion-crear-autor">Tú</p>
                <i class="fa-regular fa-bookmark" id="menu-localizacion-crear-botonfav"></i>
            </div>
            <input type="text" name="descripcion" id="menu-localizacion-crear-descripcion" placeholder="Descripción" required>
            <p id="menu-localizacion-crear-direccion"></p>
            <div id="menu-localizacion-crear-tags"></div>
        </div>
    </div>

    {{-- Menu Principal--}}
    <div id="menu-principal">
        <div id="menu-principal-navbar">
            <i class="fa-solid fa-user"></i>
            @auth
                <p id="menu-principal-username">{{ auth()->user()->name }}</p>
                {{-- <a href="{{ route('auth.logout') }}" style="color: black;"><i class="fa-solid fa-right-from-bracket"></i></a> --}}
            @else
                <p id="menu-principal-username">Guest</p>
                <a href="{{ route('auth.LoginRegistrar') }}" style="color: black;"><i class="fa-solid fa-right-to-bracket"></i></a>
            @endauth
        </div>
        <div id="menu-principal-contenidos">
            <div id="menu-principal-header">GEOEXPLORER</div>
            <div id="menu-principal-botones">
                <button class="boton-menu-principal"><i class="fa-solid fa-list-ul"></i><a href="{{ route('gincana.lista') }}">Gymkhanas</a></button>
                @auth
                    <button class="boton-menu-principal"><i class="fa-solid fa-bookmark"></i><a href="{{ route('loc.favoritas') }}">Guardadas</a></button>
                    <button class="boton-menu-principal"><i class="fa-solid fa-right-from-bracket"></i><a href="{{ route('auth.logout') }}">Cerrar sesión</a></button>
                @else
                    <button class="boton-menu-principal"><i class="fa-solid fa-right-to-bracket"></i><a href="{{ route('auth.LoginRegistrar') }}">Iniciar sesión</a></button>
                @endauth
                <button class="boton-menu-principal" id="menu-principal-boton-atras"><i class="fa-solid fa-chevron-left"></i>Atrás</button>
            </div>
        </div>
    </div>
    @endsection
