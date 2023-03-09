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
    <div id="map-buttons">
        <div class="map-buttons-section" id="check-button">
            <p>Check</p> <i class="fa-solid fa-check check-button"></i>

        </div>
    </div>
</div>


@endsection