@extends('layouts.app')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/menuPrincipal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sala.css') }}">

    <script type="text/javascript" src="{{ asset('../resources/js/menuPrincipal.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('../resources/js/gincana.js') }}" defer></script>

    {{-- Libreria QR --}}
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
@endpush

@section('content')

{{-- Formularios escondidos para JS --}}

{{-- Menu Principal --}}
    @error('gincana_id')
        {{ $message }}
    @enderror
    <div id="menu-principal" style="transform: translateX(0)">

        {{-- Navbar --}}
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

        {{-- Contenidos --}}
        <div id="menu-principal-contenidos">
            <div id="menu-principal-header"><a href="{{ route('home') }}"><i class="fa-solid fa-chevron-left"></i></a> GYMKHANA</div>
            
            {{-- Crear sala --}}
            <div id="menu-principal-subheader">
                <p id="menu-principal-subheader-titulo">{{ $gincana->nombre }}</p>
                <p id="menu-principal-subheader-subtitulo">{{ $gincana->descripcion }}</p>
            </div>

            @auth
                <form action="{{ route('sala.store') }}" method="post" style="width: 100%;">
                    @csrf 
                    <input type="hidden" name="gincana_id" value="{{ $gincana->id }}">
                    <button id="menu-sala-jugar" class="boton-verde">Crear sala</button>
                </form>
            @endauth
            
            <div id="menu-detalles-sala-wrapper">
                @auth
    
                    {{-- Si el usuario es el autor, podrá comenzar o terminar el juego --}}
                    @can('admin', $gincana)
                        <div class="menu-detalles-sala-item">
                            <div class="menu-detalles-sala-header" data-menuID="acciones">
                                <i class="fa-solid fa-chevron-down menu-detalles-header-icon"></i>
                                <p>Acciones</p>
                            </div>
                            <div class="menu-detalles-sala-contenidos" data-menuID="acciones">
                                <div class="boton-menu-principal localizacion-guardada">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <a href="{{ route('gincana.editar', $gincana->id) }}">
                                        <div class="menu-info-sala-item-usuario-nombre">
                                            Editar
                                            <div class="loc-coordenadas">
                                                {{ $gincana->nombre }}
                                                {{-- {{ $sala->gincana->autor->name }} --}}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="boton-menu-principal localizacion-guardada">
                                    <i class="fa-solid fa-ban"></i>
                                    <a href="{{ route('gincana.find', $gincana->id) }}">
                                        <div class="menu-info-sala-item-usuario-nombre">
                                            Eliminar
                                            <div class="menu-info-sala-item-usuario-nombre loc-coordenadas">
                                                {{ $gincana->nombre }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endcan
                @endauth
                <div class="menu-detalles-sala-item">
                    <div class="menu-detalles-sala-header" data-menuID="detalles">
                        <i class="fa-solid fa-chevron-down menu-detalles-header-icon"></i>
                        <p>Detalles</p>
                    </div>
                    <div class="menu-detalles-sala-contenidos" data-menuID="detalles">
                        <div class="boton-menu-principal localizacion-guardada">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <a href="{{ route('gincana.view', $gincana->id) }}">
                                <div class="menu-info-sala-item-usuario-nombre">
                                    Nombre
                                    <div class="loc-coordenadas">
                                        {{ $gincana->nombre }}
                                        {{-- {{ $sala->gincana->autor->name }} --}}
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="boton-menu-principal localizacion-guardada">
                            <i class="fa-solid fa-user"></i>
                            <div class="menu-info-sala-item-usuario-nombre">
                                Creador
                                <div class="menu-info-sala-item-usuario-nombre loc-coordenadas">
                                    {{ $gincana->autor->name }}
                                </div>
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
                        <p>Salas</p>
                    </div>
                    <div class="menu-detalles-sala-contenidos" data-menuID="jugadores">
                        @foreach ($gincana->salas as $sala)
                            <a href="{{ route('sala.view', $sala->id) }}">
                                <div class="boton-menu-principal localizacion-guardada">
                                    <i class="fa-solid fa-user"></i>
                                    <div class="menu-info-sala-item-usuario-nombre">
                                        Sala {{ $sala->id}}
                                        <p class="loc-coordenadas">
                                            {{ $sala->creador->name }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection