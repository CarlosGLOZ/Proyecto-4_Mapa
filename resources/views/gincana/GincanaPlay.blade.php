@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{asset('css/GincanaPlay.css')}}">
<script src="{{ asset('../resources/js/GincanaPlay.js') }}" defer></script>

{{-- Google Maps API --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDy0Ba3CPpNH48X3toUBGCrgQhaEvxaZks&callback=initMap&v=weekly" defer></script>

@endpush

@section('content')

<div id="main-home">
    <x-navbar />
    <div id="mapa-main"></div>
    <div class="info">
        <div>
            <div class="persona">
                <i class="fa-solid fa-user"></i>
                <p>Persona</p>
            </div>
            <div class="logout">
                <i class="fa-solid fa-arrow-rotate-left"></i>


            </div><br>

        </div>

        <div class="gincana">
            <p>Gincana</p>
        </div>

    </div>
    <div id="pista">
        <div class="titulo-desplegable" >
            <p>Pista</p>
            <i class="fa-solid fa-caret-down"></i>
        </div>

        <div class="desplegable" >
            <p>jaksdjflñkjasdfñlkjasasdfaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaadf</p>
        </div>

    </div>
    <div id="map-buttons">
        <div class="map-buttons-section" id="check-button">
            <p>Check</p> <i class="fa-solid fa-check check-button"></i>
        </div>
    </div>
</div>


@endsection