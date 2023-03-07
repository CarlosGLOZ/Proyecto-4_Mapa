@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{asset('css/LoginRegistrar.css')}}">

@endpush

@section('content')

<div class="main-container">
    <div class="img-principal">
        <img src="" alt="">
    </div>
    <div class="Login">
        <div class="titulo">
            <p></p>
        </div>
        <form action="{{ route('auth.LoginRegistrar') }}" method="post">
            @csrf
            <div class="inputs">
                <input type="email" name="email" placeholder="email">
            </div>
            <div class="inputs">
                <input type="password" name="password" placeholder="password">
            </div>

            <div class="Button">
                <button type="submit">Entrar</button>
            </div>
        </form>
    </div>

    <div class="Registrar">
        <div class="titulo">
            <p></p>
        </div>
        <form action="{{ route('auth.LoginRegistrar') }}" method="post">
            @csrf
            <div class="inputs">
                <input type="text" name="name" placeholder="Nombre">
            </div>
            <div class="inputs">
                <input type="email" name="email" placeholder="Email">
            </div>
            <div class="inputs">
                <input type="password" name="password" placeholder="Contraseña">
            </div>
            <div class="inputs">
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña">
            </div>
            <div class="Button">
                <button type="submit">Entrar</button>
            </div>
        </form>
    </div>

</div>

@endsection