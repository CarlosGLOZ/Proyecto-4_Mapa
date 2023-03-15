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
            <div class="tittle">
                <span>New Gincana</span>
                <div><i class="fa-solid fa-floppy-disk"></i></div>
            </div>
            <span class="header-toggle"><i class="fa-solid fa-chevron-up"></i></span>
            <div class="inputs" id="inputs">
                <input type="text"  id="ginNombre" name="ginNombre" placeholder="Name">
                <textarea id="descripcion" name="descripcion" placeholder="Descripcion"></textarea>
                <i id="check1" name="check" class="fa-solid fa-circle-check check1"></i>
            </div>
            <div class="inputs" id="titles"></div>
            <div class="point-info" id="point-box">
                <span id="active-point" value="1">Point1</span>
                <textarea id="pista" name="pista" placeholder="Pista"></textarea>
                <div class="buttons-confPoint">
                    <i id="check2" name="check" class="fa-solid fa-circle-check"></i>
                    <i class="fa-sharp fa-solid fa-circle-xmark"></i>
                </div>

            </div>
            <div class="points" id="points-box">
                <span class="point-span" value="1">P1</span>
                <span class="add-point-span" id="addPoint">+</span>
            </div>
        </div>

        <div id="mapa-main"></div>
    </div>


@endsection
