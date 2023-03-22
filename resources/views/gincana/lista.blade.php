@extends('layouts.app')

@push('head')
    <link rel="stylesheet" href="{{asset('css/gincana.css')}}">
    <link rel="stylesheet" href="{{ asset('css/menuPrincipal.css') }}">
    <script type="text/javascript" src="{{asset('../resources/js/gincana.js')}}" defer></script>
@endpush

@section('content')
    {{-- Formularios escondidos para JS --}}
    <form action="{{ route('gincana.view', '') }}" method="get" id="form-gincanas-find"></form>

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
            <div id="menu-principal-header">GYMKHANAS</div>
            <button class="boton-menu-principal" id="menu-principal-boton-atras"><i class="fa-solid fa-chevron-left"></i><a href="{{ route('home') }}">Atrás</a></button>
            <div>
                <form action="{{ route('gincana.filtrar') }}" method="POST" id="menu-gincanas-filtros">
                    @csrf
                    <input type="text" name="buscar" id="menu-gincanas-filtro-nombre" placeholder="Buscar...">
                    @auth
                        <button class="boton-toggle-inactivo" id="gincana-propia-toggle" data-activo="false">Mis Gincanas</button>
                    @endauth
                </form>
                <div id="menu-gincanas" class="menu-principal-botones">
                    <button class="boton-menu-principal" id="menu-principal-boton-atras"><i class="fa-solid fa-chevron-left"></i><a href="{{ route('home') }}">Atrás</a></button>
    
                </div>
            </div>
        </div>
    </div>
@endsection

