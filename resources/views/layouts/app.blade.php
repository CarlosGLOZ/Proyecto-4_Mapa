<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="_token">
    <title>Mapa</title>
    <script src="https://kit.fontawesome.com/2b5286e1aa.js" crossorigin="anonymous"></script>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">  
    

    @stack('css')
    @stack('js')

    @stack('head')
</head>

<body>
    {{-- Navbar --}}

    {{-- Contenido --}}
    @yield('content')
</body>

</html>