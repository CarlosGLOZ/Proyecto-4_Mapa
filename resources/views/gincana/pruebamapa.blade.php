@extends('layouts.app')

@push('css')
@endpush

@push('js')
@endpush

@push('head')
    <script         src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDy0Ba3CPpNH48X3toUBGCrgQhaEvxaZks&libraries=places&callback=initMap&v=weekly"         defer     ></script>
@endpush

@section('content')
    <div id="map" style="height: 500px; width: 500px"></div>

    <script defer>
        let map;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -34.397, lng: 150.644 },
                zoom: 8,
            });

            const marker1 = new google.maps.Marker({
                position: { lat: 40.712776, lng: -74.005974 },
                map: map,
                title: 'Marcador 1'
            });

            const marker2 = new google.maps.Marker({
                position: { lat: 40.732876, lng: -74.003872 },
                map: map,
                title: 'Marcador 2'
            });

            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
            });

            const request = {
                origin: marker1.getPosition(),
                destination: marker2.getPosition(),
                travelMode: 'DRIVING'
            };

            directionsService.route(request, function(result, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);
                } else {
                    console.log('Error al cargar las direcciones:', status);
                }
            });
        }
    </script>
@endsection
