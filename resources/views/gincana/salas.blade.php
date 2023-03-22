@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('css/salas.css')}}">
@endpush
@push('js')
    <script type="text/javascript" src="{{asset('js/gincana.js')}}" defer></script>
@endpush
@section('head')






@endsection

@section('content')
    <header class="header">

    </header>
    <div class="main">

        <div>
{{--{{dd($salas1->salas)}}--}}

            <h1>{{$salas1->nombre}}</h1>
            <p>{{$salas1->descripcion}}</p>
            <button class="button">Crear sala</button>

            <div class="puntos">
                <div>
                    <label> Creador: {{$salas1->autor->name}}</label>
                </div>
                <div>
                    <label>Puntos: {{$salas1->puntos}}</label>
                </div>
            </div>
        </div>

    </div>

    <div class="salas">
        @foreach($salas1->salas as $sala)

        <label style="margin-left: 34%">Uniros a una sala</label>
        <div class="rectangulo">
            <label>{{$sala->codigo_entrada}}</label>
        </div>
    </div>
    </div>
@endforeach

    {{--    <footer class="footer">--}}
    {{--        <h2>Título de la sección</h2>--}}
    {{--        <div class="box">--}}
    {{--            <p>Texto dentro de la caja</p>--}}
    {{--        </div>--}}
    {{--    </footer>--}}

@endsection
