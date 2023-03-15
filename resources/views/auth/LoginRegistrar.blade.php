@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{asset('css/LoginRegistrar.css')}}">

@endpush

@section('content')

<div class="main-container">
    <div class="img-principal">
        <img src="{{asset('storage/img/imagen-login.png')}}" alt="">
    </div>
    <div class="titulo">
        <p>GEOEXPLOER</p>
    </div>
    <div class="Login" id="login">

        <form action="{{ route('auth.login') }}" method="post">
            @csrf
            <div class="inputs">
                <input type="email" name="email" placeholder="Email">
            </div>
           
            <div class="inputs">
                <input type="password" name="password" placeholder="Password">
            </div>

            <div class="Button" id="botonEnviar">
                <button type="submit" >LOG IN</button>
            </div>
            <div class="Button2">
                <button id="SingUp">sing up</button>
            </div>
        </form>
    </div>

    <div class="Registrar" id="registrar">
        <form name="registrar" action="{{ route('auth.registrar') }}" method="post">
            @csrf
            <div class="inputs">
                <input type="text" name="name" placeholder="Nombre">
            </div>
            @error('name')
                <p>{{ $message }}</p>
            @enderror
            <div class="inputs">
                <input type="email" name="email" placeholder="Email">
            </div>
            @error('email')
                <p>{{ $message  }}</p>
            @enderror
            <div class="inputs">
                <input type="password" name="password" placeholder="Contraseña">
            </div>
            @error('password')
                <p>{{ $message  }}</p>
            @enderror
            <div class="inputs">
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña">
            </div>
            <div class="Button" id="botonEnviar2">
                <button type="submit" >Sing Up</button>
            </div>
            <div class="Button2">
                <button id="LogIn">log in</button>
            </div>
        </form>
    </div>

</div>

@push('js')

<script src="{{ asset('../resources/js/LoginRegistrar.js') }}"></script>

@endsection
