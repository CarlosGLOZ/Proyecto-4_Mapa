@extends('layouts.app')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/menuPrincipal.css') }}">
    <script type="text/javascript" src="{{asset('../resources/js/sala.js')}}" defer></script>
    <link rel="stylesheet" href="{{asset('css/sala.css')}}">
    <script type="text/javascript" src="{{ asset('../resources/js/menuPrincipal.js') }}" defer></script>


    {{-- Libreria QR --}}
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
@endpush

@section('content')
    {{-- Formularios escondidos para JS --}}
    <form action="{{ route('gincana.view', '') }}" method="get" id="form-gincanas-find"></form>
    <form action="{{ route('sala.acceso', $sala) }}" method="post" id="form-sala-acceso">@csrf</form>

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
                {{-- Si el usuario es el creador, podrá comenzar o terminar el juego --}}
                @can('admin', $sala)
                    @if ($sala->activa)
                        <form action="{{ route('sala.estado', $sala) }}" method="post" style="width: 100%">
                            @csrf
                            <button id="menu-sala-comenzar" class="boton-rojo">Terminar</button>
                        </form>
                    @else
                        <form action="{{ route('sala.estado', $sala) }}" method="post" style="width: 100%">
                            @csrf
                            <button id="menu-sala-comenzar" class="boton-verde">Comenzar</button>
                        </form>
                    @endif
                @endcan

                @if ($sala->activa)
                <a href="{{ route('sala.jugar', $sala) }}" style="width: 100%;"><button id="menu-sala-jugar" class="boton-verde">Unirse al juego</button></a>
                @endif

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
                            <a href="{{ route('gincana.view', $sala->gincana->id) }}">
                                <div class="menu-info-sala-item-usuario-nombre">
                                    Gymkhana
                                    <div class="loc-coordenadas">
                                        {{ $sala->gincana->nombre }}
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
                                    {{ $sala->creador->name }}
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

