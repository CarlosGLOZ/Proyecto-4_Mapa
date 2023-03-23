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
            @if($gin)
                <input id='ginID' type='hidden' value={{json_decode($gin)->id}}><h3>{{json_decode($gin)->nombre}}</h3>
            @endif
            <div class="inputs" id="titles"></div>
            <div class="point-info" id="point-box">
                <span id="active-point" value="1">Point1</span>
                <textarea id="pista" name="pista" placeholder="Pista"></textarea>
                <div class="buttons-confPoint">
                    <i id="check2" name="check" class="fa-solid fa-circle-check"></i>
                    <i id="check3" class="fa-sharp fa-solid fa-circle-xmark"></i>
                </div>

            </div>
            <div class="points" id="points-box">
                @foreach($gin->puntos as $punto)

                    <span class="point-span" value="{{$punto->posicion}}">P{{$punto->posicion}}</span>
                @endforeach
                <span class="add-point-span" id="addPoint">+</span>
            </div>
        </div>
        <div id="mapa-main"></div>
    </div>


@endsection
