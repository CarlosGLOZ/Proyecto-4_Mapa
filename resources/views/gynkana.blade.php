@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('css/gincana.css')}}">
@endpush
@push('js')
    <script type="text/javascript" src="{{asset('js/gincana.js')}}" defer></script>
@endpush
@section('head')






@endsection

@section('content')
<div class="navbar">
    <h1>GymKhama</h1>

</div>
<div class="search-box">
    <div style="display: flex ;align-items: center">
        <div style="width: 88%">
   <a href="{{url('/gynkana')}}"> <button class="boton1"><i class="fas fa-arrow-left"></i></button></a>
        </div>
        <div style="width: 12%; align-items: end">
    <button onclick="listar()"  id="button">⭐</button>
        </div>
    </div>
    <br>
    <form action="" method="post">
        <input type="text" name="buscar" id="buscar" placeholder="nombre">
    </form>
    <div class="div1" id="div1">

            @foreach($gincana as $gincanas)

    <div class="container" >
        <div id="resultado">
        </div>
    <p >{{$gincanas->nombre}}</p>
    </div>
    @endforeach
    </div>

    <!-- Agregar el primer botón -->


    <!-- Agregar el segundo botón -->
    <button class="boton-abajo-derecha"><i class="fa-regular fa-plus"></i></button>

</div>



@endsection

