@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('css/crearGymkhana.css')}}">
@endpush

@push('js')
    <script src="{{ asset('../resources/js/createGymkhana.js') }}" defer></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDy0Ba3CPpNH48X3toUBGCrgQhaEvxaZks&callback=initMap&v=weekly"--}}
        defer
   ></script>
@endpush

@section('head')

@endsection

@section('content')
   <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <div class="content">
        <div class="header">
            <span class="header-toggle"><i class="fa-solid fa-chevron-up"></i></span>
        </div>
        <div id="mapa-main"></div>
    </div>


@endsection
