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
        <h1> Barcelona Sud</h1>
    </header>
    <div class="main">
        <div>
            <h1>Barcelona Sud</h1>
            <p>Descripción de Barcelona Sud, Descripción de Barcelona Sud,Descripción de Barcelona Sud,Descripción de
                Barcelona Sud,Descripción de Barcelona Sud</p>
            <button class="button">Crear sala</button>

            <div class="puntos">
                <div>
                    <label> Creador: Raul</label>
                </div>
                <div>
                    <label>Puntos: 4</label>
                </div>
            </div>
        </div>

    </div>

    <div class="salas">
        <label style="margin-left: 34%">Uniros a una sala</label>

        <div class="rectangulo">

        <label>OY67G4</label>

        </div>
        <div class="rectangulo">

            <label>OY67G4</label>

        </div>
        <div class="rectangulo">

            <label>OY67G4</label>

        </div>
    </div>
    </div>
    {{--    <footer class="footer">--}}
    {{--        <h2>Título de la sección</h2>--}}
    {{--        <div class="box">--}}
    {{--            <p>Texto dentro de la caja</p>--}}
    {{--        </div>--}}
    {{--    </footer>--}}

@endsection
