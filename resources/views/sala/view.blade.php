@extends('layouts.app')

@push('head')
<link rel="stylesheet" href="{{ asset('css/menuPrincipal.css') }}">
<script type="text/javascript" src="{{asset('../resources/js/sala.js')}}" defer></script>
<link rel="stylesheet" href="{{asset('css/sala.css')}}">

{{-- Libreria QR --}}
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
@endpush

@section('content')
    {{-- Formularios escondidos para JS --}}
    <form action="{{ route('gincana.find', '') }}" method="get" id="form-gincanas-find"></form>

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
            <div id="menu-principal-header"><a href="{{ route('home') }}"><i class="fa-solid fa-chevron-left"></i></a> SALA</div>
            @auth
                @can('jugador', $sala)
                    {{-- El usuario es jugador de la gincana --}}
                    <button id="menu-sala-unirse">Abandonar</button>
                @else
                    {{-- El usuario no es jugador de la gincana --}}
                    <button id="menu-sala-unirse">Unirse</button>
                @endcan
            @endauth
            <div id="menu-detalles-sala-wrapper">
                <div class="menu-detalles-sala-item">
                    <div class="menu-detalles-sala-header" data-menuID="detalles">
                        <i class="fa-solid fa-chevron-down menu-detalles-header-icon"></i>
                        <p>Detalles</p>
                    </div>
                    <div class="menu-detalles-sala-contenidos" data-menuID="detalles">
                        <div class="boton-menu-principal localizacion-guardada">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <div class="menu-info-sala-item-usuario-nombre">
                                {{ $sala->gincana->nombre }}
                                <div class="loc-coordenadas">
                                    {{ $sala->gincana->autor->name }}
                                </div>
                            </div>
                        </div>
                        <div class="boton-menu-principal localizacion-guardada">
                            <i class="fa-solid fa-user"></i>
                            <div class="menu-info-sala-item-usuario-nombre">
                                {{ $sala->creador->name }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="menu-detalles-sala-item">
                    <div class="menu-detalles-sala-header" data-menuID="compartir">
                        <i class="fa-solid fa-chevron-down menu-detalles-header-icon"></i>
                        <p>Compartir</p>
                    </div>
                    <div class="menu-detalles-sala-contenidos" data-menuID="compartir">
                        <div class="boton-menu-principal localizacion-guardada" id="menu-info-sala-item-compartir-link" data-url="{{ url()->current() }}">
                            <i class="fa-solid fa-globe"></i>
                            <div class="menu-info-sala-item-usuario-nombre">
                                <div class="item-titulo-wrapper">
                                    Copiar link
                                    <p class="item-subtitulo aviso-copiado" style="color: transparent">Copiado!</p>
                                </div>
                                <div class="loc-coordenadas">
                                    Cualquier persona con este link podrá unirse
                                </div>
                            </div>
                        </div>
                        <div class="boton-menu-principal localizacion-guardada" id="qr-compartir-wrapper">
                            <div class="menu-info-sala-item-usuario-nombre" id="qr-compartir">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu-gincanas" class="menu-principal-botones">
                <div class="menu-detalles-sala-item">
                    <div class="menu-detalles-sala-header" data-menuID="jugadores">
                        <i class="fa-solid fa-chevron-down menu-detalles-header-icon"></i>
                        <p>Jugadores</p>
                    </div>
                    <div class="menu-detalles-sala-contenidos" data-menuID="jugadores">
                        @foreach ($sala->jugadores as $jugador)
                            <div class="boton-menu-principal localizacion-guardada">
                                <i class="fa-solid fa-user"></i>
                                <div class="menu-info-sala-item-usuario-nombre">
                                    {{ $jugador->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

