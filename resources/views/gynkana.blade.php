@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('css/gincana.css')}}">
@endpush
@push('js')
    <script type="javascript" src="{{asset('js/gincana.js')}}"></script>
@endpush
@section('head')






@endsection

@section('content')
<div class="navbar">
    <h1>GymKhama</h1>

</div>
<div class="search-box">
   @foreach($gincana as $gincanas)
    <input type="text" placeholder="Buscar..." style="border-color: black">
    <div class="container" >
        <div id="resultado">
        </div>
    <p >{{$gincanas->nombre}}</p>
    </div>
    <button id="button"><i class="fa fa-search"></i></button>
                @endforeach
</div>



@endsection
