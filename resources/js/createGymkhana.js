window.onload = function (e){

    //estilos header. Funcionalidad de ocultar y mostrar
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

        document.getElementById('check1').addEventListener('click',function (e){
            saveGincana(document.getElementById('ginNombre').value,document.getElementById('descripcion').value)
        })

        document.getElementById('check2').addEventListener('click', function (e){
            alert(document.getElementById('active-point').getAttribute('value'))
            savePista(document.getElementById('active-point').getAttribute('value'), document.getElementById('pista').value)

        })

   //Funcionalidad puntos


    var activePoint //variable que contiene el html del punto con el foco (es decir el punto editable en el formulario)

       //añadir puntos a la lista
        document.getElementById('addPoint').addEventListener('click', function (e) {
            let pointsBox = document.getElementById('points-box');
            let points = document.getElementsByClassName('point-span');
            let index = points[points.length-1].getAttribute('value');

            // Create the new span element
            let newPoint = document.createElement('span');
            newPoint.setAttribute('class', 'point-span');
            newPoint.setAttribute('value', parseInt(index) + 1);
            newPoint.innerText = "P" + (parseInt(index) + 1);

            // Insert the new span element before the "Add Point" button
            pointsBox.insertBefore(newPoint, document.getElementById('addPoint'));
            addPointsClickEvent()
        });

       //cambiar focus de punto al hacer click en un punto al inciar la ventana
        addPointsClickEvent()


}


function addPointsClickEvent(){
    let points= document.getElementsByClassName('point-span') //recoger todos los puntos
    for (let i=0; i<points.length; i++){
        //al hacer click en un punto cambiar el foco a ese punto
        points[i].addEventListener('click',function (e){
            changePointFocus(e)
        })
    }

}

function changePointFocus(e){
    const activePointSpan=document.getElementById('active-point')
    if (typeof activePoint !== 'undefined'){
        activePoint.style.backgroundColor='gray'
        activePoint.style.color='white'
        activePoint=e.target
        activePointSpan.innerHTML="Point "+e.target.getAttribute('value')
        activePointSpan.setAttribute('value',e.target.getAttribute('value'))
        activePoint.style.backgroundColor='black'
        activePoint.style.color='white'
    }else{
        activePoint=e.target
        activePoint.style.backgroundColor='black'
        activePoint.style.color='white'
    }


}



function saveGincana(nombre,descripcion){
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var ajax = new XMLHttpRequest();
    var formada = new FormData();
    formada.append('nombre', nombre)
    formada.append('descripcion', descripcion)
    ajax.open('post', "./saveGin");
    ajax.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    ajax.onload = function () {
        if (ajax.status == 201) {
            const data=JSON.parse(ajax.responseText)
            alert(data.id)
            document.getElementById('inputs').style.display="none"
            document.getElementById('ginNombre').style.display="none"
            document.getElementById('titles').innerHTML="<input type='hidden' value="+data.id+"><h3>"+data.nombre+"</h3>"
            document.getElementById('point-box').style.display="flex"
            document.getElementById('points-box').style.display="flex"

        }
    }
    ajax.send(formada);
}

async function savePista(pistaId, pista){


    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var ajax = new XMLHttpRequest();
    var formada = new FormData();
    formada.append('id', pistaId)
    formada.append('content', pista)
    await formada.append('localizacion', activemark)
    ajax.open('post', "./savePista");
    ajax.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    ajax.onload = function () {
        if (ajax.status == 201) {
            const data=JSON.parse(ajax.responseText)
            console.log(data.id)


        }
    }
    ajax.send(formada);
}










// CODIGO MAPA

//////////////////////////////////////////////////////////////////////////////////////////////////77


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

         var marcador = new google.maps.Marker({
             position: position,
             map: map,



         });
         if (activemark.length >=1){
             setMapOnAll(null);
             activemark = [];
             marcador.setIcon(null);
             console.log("Vacia2: "+activemark.length)
         }
         activemark.push(marcador)
         map.panTo(position);
    }

         function placeIPMarker(position,map){

            var marcador = new google.maps.Marker({
                position: position,
                map: map,



            });
            if (activemark.length >=1){
                setMapOnAll(null);
                activemark = [];
                marcador.setIcon(null);
                console.log("Vacia2: "+activemark.length)
            }
            activemark.push(marcador)
            map.panTo(position);
        }


    function setMapOnAll() {
       console.log( activemark.length)
        for (var i = 0; i < activemark.length; i++) {
            activemark[i].setMap(null);
        }

    }

window.initMap = initMap;
