@extends('layouts.app')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/menuPrincipal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menuLocalizacion.css') }}">

    {{-- Google Maps API --}}
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDy0Ba3CPpNH48X3toUBGCrgQhaEvxaZks&libraries=places&v=weekly"
    defer
    ></script>

    <script src="{{ asset('../resources/js/menuGuardadas.js') }}" defer></script>
@endpush

@section('content')
    {{-- Formularios escondidos para el JS --}}
    <form action="{{ route('loc.find') }}" method="post" id="formulario-loc-find">@csrf</form>
    <form action="{{ route('loc.likeLocalizacion') }}" method="get" id="form-store-like">@csrf</form>
    <form action="{{ route('loc.unlikeLocalizacion') }}" method="get" id="form-destroy-like">@csrf @method('DELETE')</form>
    <form action="{{ route('loc.asyncFavoritas') }}" method="get" id="form-async-likes"></form>

    {{-- Menu Principal --}}
    <div id="menu-principal" style="transform: translateX(0)">
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
            <div id="menu-principal-header">GUARDADAS</div>
            <div class="menu-principal-botones">
                <button class="boton-menu-principal" id="menu-principal-boton-atras"><i class="fa-solid fa-chevron-left"></i><a href="{{ route('home') }}">Atrás</a></button>
                @foreach ($localizacionesFavoritas as $loc)
                    <button class="boton-menu-principal localizacion-guardada boton-loc-bdd" data-id="{{ $loc->id }}">
                        <i class="fa-solid fa-user"></i>
                        <div>
                            {{ $loc->nombre }}
                            <div class="loc-coordenadas">
                                {{ $loc->latitud }},
                                {{ $loc->longitud }}
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Menu con info --}}
    <div id="menu-localizacion" style="position: fixed;">
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
                <i class="fa-solid fa-bookmark" id="menu-localizacion-botonfav" style="color: rgb(228, 225, 0);" data-action="removeLike"></i>
            </div>
            <p id="menu-localizacion-descripcion"></p>
            <p id="menu-localizacion-direccion"></p>
            <div id="menu-localizacion-tags"></div>
        </div>
    </div>
@endsection
