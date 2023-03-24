@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('css/crearGymkhana.css')}}">
@endpush

@push('js')
    <script src="{{ asset('../resources/js/createGymkhana.js') }}" defer></script>
@endpush

@section('head')

@endsection

@section('content')

    <div class="full-page">

            <div class="principal-title">
                <span>New Gincana</span>
            </div>
            <div class="inputs" id="inputs">
                <input type="text"  id="ginNombre" name="ginNombre" placeholder="Name">
                <textarea id="descripcion" name="descripcion" placeholder="Descripcion"></textarea>
                <i id="check1" name="check" class="fa-solid fa-circle-check check1"></i>
            </div>
        <div class="line-box"><hr><p>Or</p><hr></div>
        <div class="tus-gincanas-box">Tus Gincanas</div>
    </div>



@endsection
