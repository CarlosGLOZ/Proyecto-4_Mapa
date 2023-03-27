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
                <form action="{{ route('gincana.store') }}" method="post" id="form-crear-gincana" style="display: flex; flex-direction: column; align-items: center; width: 393px;">
                    @csrf
                    <input type="text"  id="ginNombre" name="nombre" placeholder="Name">
                    <textarea id="descripcion" name="descripcion" placeholder="Descripcion"></textarea>
                    <i id="check1" name="check" class="fa-solid fa-circle-check check1"></i>
                </form>
            </div>
        <div class="line-box"><hr><p>Or</p><hr></div>
        <a href="{{route('gincana.lista')}}" class="tus-gincanas-box">Volver atras</a>
    </div>
    <div id="alert" class="alert hide"></div>
    <div id="message" class="message hide"></div>



@endsection
