window.onload = function (e){
    //estilos header

    const header = document.querySelector('.header');
    const mapaMain = document.getElementById('mapa-main');
    const headerToggle = document.querySelector('.header-toggle');
    headerToggle.addEventListener('click', (event) => {
        event.stopPropagation();
        if (parseInt(getComputedStyle(header).height)>=200 || header.style.height==='25vh') {
            mapaMain.style.height='95vh'
            mapaMain.style.top='5.5vh'
            header.style.height ='5vh'; // Altura de header visible en centímetros (ej: 5cm => -20vh)
            headerToggle.innerHTML = '<i class="fa-solid fa-chevron-down"></i>';
        }else if (header.style.height=='5vh'){
            mapaMain.style.height='75vh';
            mapaMain.style.top='25vh';
            header.style.height = '25vh';
            headerToggle.innerHTML = '<i class="fa-solid fa-chevron-up"></i>';
        }
    });

}

const mapaMain = document.getElementById('mapa-main');
var activemark=[]
var place=false

//icono que cuando hagas click en un punto de interest lo remplazará por este

function initMap() {


    //creamos el mapa
    const centerPoint = {lat: 41.374961, lng: 2.149080};

    const map = new google.maps.Map(document.getElementById("mapa-main"), {
        zoom: 15,
        center: centerPoint,
        disableDefaultUI: true,
        icon: {
            scaledSize: new google.maps.Size(50, 50)
        }
    });


    map.addListener('click', function (event) {
        // If the event is a POI
        if (event.placeId) {
            // Call event.stop() on the event to prevent the default info window from showing.
            event.stop();
            // do any other stuff you want to do
            console.log('You clicked on place:' + event.placeId + ', location: ' + event.latLng);
             place=true;
        }else{
            console.log('You clicked on location: ' + event.latLng);
             place=false;
        }
        if(place==false){
            placeMarker(event.latLng, map);
        }else{
            placeIPMarker(event.latLng,map)
        }

    })
}


    function placeMarker(position, map, ) {


        var marker = new google.maps.Marker({
            position: position,
            map: map
        });


        if (activemark.length ==1){
            deleteMarks();
            marker.setIcon(null);
        }
        activemark.push(marker)
        map.panTo(position);
    }

        function placeIPMarker(position,map){

            var marcador = new google.maps.Marker({
                position: position,
                map: map,



            });
            if (activemark.length ==1){
                deleteMarks();
                marcador.setIcon(null);
            }
            activemark.push(marcador)
            map.panTo(position);
        }
    function deleteMarks(){
        setMapOnAll(null);
        activemark = [];
    }

    function setMapOnAll() {
       activemark[0].setMap(null)
    }

window.initMap = initMap;



