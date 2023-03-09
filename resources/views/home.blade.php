@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/mapa.css') }}">
    <script src="{{ asset('../resources/js/mapa.js') }}" defer></script>

    {{-- Google Maps API --}}
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDy0Ba3CPpNH48X3toUBGCrgQhaEvxaZks&callback=initMap&v=weekly"
      defer
    ></script>
@endpush

@section('content')
    <div id="main-home">
        <x-navbar />
        <div id="mapa-main"></div>
        <div id="map-buttons">
            <div class="map-buttons-section">
                <i class="fa-regular fa-star"></i>
            </div>
            <div class="map-buttons-section">
                <i class="fa-solid fa-arrow-right-from-bracket map-button"></i>
                <i class="fa-solid fa-map-location-dot map-button" id="map-icon-button"></i>
            </div>
        </div>
    </div>
    
    
@endsection