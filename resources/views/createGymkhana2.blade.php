@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('css/crearGymkhana.css')}}">
@endpush

@push('js')
    <script src="{{ asset('../resources/js/createGymkhana.js') }}" defer></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDy0Ba3CPpNH48X3toUBGCrgQhaEvxaZks&callback=initMap&v=weekly"
        defer
   ></script>
@endpush

@section('head')

@endsection

@section('content')
   <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <div class="content">
        <div class="header">
            @if($gincana)
                <input id='ginID' type='hidden' value={{json_decode($gincana)->id}}><h3>{{json_decode($gincana)->nombre}}</h3>
            <div class="inputs" id="titles"></div>
                <div id="container">
                    <button id="toggle-button">  <i class="fas fa-question"></i></button>
                    <div class="point-info" id="point-box">
                        <span id="close">x</span>
                        <span id="active-point" value="undefined">No selec.</span>
                        <textarea id="pista" class="pista-textArea" name="pista" placeholder="Pista"></textarea>

                    </div>
                </div>
            <div class="points" id="points-box">

                @if($gincana->puntos->isEmpty())
                    <button class="point-span" value="1">P1</button>
                @else
                    @foreach($gincana->puntos as $punto)
                        <button class="point-span" value="{{$punto->posicion}}">P{{$punto->posicion}}</button>

                    @endforeach
                @endif
                @else
                    <button class="point-span" value="1"></button>
                @endif

                <button class="add-point-span" id="addPoint">+</button>
            </div>
        </div>
        <div class="buttons-confPoint">
            <i id="check2" name="check" class="fa-solid fa-circle-check"></i>
            <i id="check3" class="fa-sharp fa-solid fa-circle-xmark"></i>
        </div>

        <div id="mapa-main"></div>
        <div id="alert" class="alert hide"></div>
        <div id="message" class="message hide"></div>
    </div>



@endsection
