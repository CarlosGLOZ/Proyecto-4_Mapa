window.onload = function (e){


    //estilos header. Funcionalidad de ocultar y mostrar
        const header = document.querySelector('.header');
        const mapaMain = document.getElementById('mapa-main');
        const headerToggle = document.querySelector('.header-toggle');
        if (headerToggle){
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

        if (document.getElementById('check1')){
            document.getElementById('check1').addEventListener('click',function (e){
                saveGincana(document.getElementById('ginNombre').value,document.getElementById('descripcion').value)
            })
        }
       if (document.getElementById('check2')){
           document.getElementById('check2').addEventListener('click', function (e){
               savePista(document.getElementById('active-point').getAttribute('value'), document.getElementById('pista').value)

           })
       }
    if (document.getElementById('check3')){
        document.getElementById('check3').addEventListener('click', function (e){
            deletePista(document.getElementById('active-point').getAttribute('value'), document.getElementById('pista').value)

        })
    }


   //Funcionalidad puntos


    var activePoint //variable que contiene el html del punto con el foco (es decir el punto editable en el formulario)
    if (  document.getElementById('addPoint')){
        //añadir puntos a la lista
        document.getElementById('addPoint').addEventListener('click', function (e) {

            let pointsBox = document.getElementById('points-box');
            let points = document.getElementsByClassName('point-span');
            let index = points[points.length - 1].getAttribute('value');

            // Create the new span element

            //Peticion ajax que me va a comprobar que todos los puntos esten complentos antes de añadir otro (tmb sirve al guardar gincana)

            let Allpoints = document.getElementsByClassName('point-span')
            let finalPoint = (Allpoints[Allpoints.length - 1]).getAttribute('value')
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const ginID = document.getElementById('ginID').value
            var ajax = new XMLHttpRequest();
            var formada = new FormData();
            formada.append('PointId', e.target.getAttribute('value'))
            formada.append('ginID', ginID)
            formada.append('finalPoint',finalPoint)
            ajax.open('post', "./PointComplete");
            ajax.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            ajax.onload = function () {
                if (ajax.status == 200) {
                    if (ajax.responseText ==1) {
                        console.log(ajax.responseText)
                        let newPoint = document.createElement('span');
                        newPoint.setAttribute('class', 'point-span');
                        newPoint.setAttribute('value', parseInt(index) + 1);
                        newPoint.innerText = "P" + (parseInt(index) + 1);

                        // Insert the new span element before the "Add Point" button
                        pointsBox.insertBefore(newPoint, document.getElementById('addPoint'));


                    }
                }


            }
            ajax.send(formada);
            addPointsClickEvent()
        });

        //cambiar focus de punto al hacer click en un punto al inciar la ventana
        addPointsClickEvent()


    }
    }

const mapaMain = document.getElementById('mapa-main');
var activemark=[]
var place=false

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


    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const ginID= document.getElementById('ginID').value
    var ajax = new XMLHttpRequest();
    var formada = new FormData();
    formada.append('PointId', e.target.getAttribute('value'))
    formada.append('ginID', ginID)
    ajax.open('post', "./getLocaFromPoint");
    ajax.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    ajax.onload = function () {
        if (ajax.status==200){
            if (ajax.responseText !=="false"){
                data=JSON.parse(ajax.responseText)

                document.getElementById('pista').value=data.pista
                const ubicacionMarcador = new google.maps.LatLng(data.localizacion.latitud, data.localizacion.longitud);
                const map = new google.maps.Map(document.getElementById("mapa-main"), {
                    zoom: 15,
                    center: ubicacionMarcador,
                    disableDefaultUI: true,
                    icon: {
                        scaledSize: new google.maps.Size(50, 50)
                    }
                });


                placeMarker(ubicacionMarcador, map)

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
            }else{
                setMapOnAll(null);
                activemark = [];
                document.getElementById('pista').value=null
            }
        }
    }
    ajax.send(formada);


    const activePointSpan=document.getElementById('active-point')
    if (typeof activePoint !== 'undefined'){
        activePoint.style.backgroundColor='gray'
        activePoint.style.color='white'
        activePoint=e.target
        activePointSpan.innerHTML="Point "+e.target.getAttribute('value')
        console.log(e.target)
        activePointSpan.setAttribute('value',e.target.getAttribute('value'))
        activePoint.style.backgroundColor='black'
        activePoint.style.color='white'

    }else{
        activePoint=e.target
        activePointSpan.innerHTML="Point "+e.target.getAttribute('value')
        console.log(e.target)
        activePointSpan.setAttribute('value',e.target.getAttribute('value'))
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
        if (ajax.status == 201 || ajax.status==200) {
            var gincana = JSON.parse(ajax.responseText); // Parse the response as JSON
            var url = "./createGincana2/" + JSON.stringify(gincana);
            window.location.href = url;

        }
    }
    ajax.send(formada);
}

async function savePista(pistaId, pista){


    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const ginID= document.getElementById('ginID').value
    var ajax = new XMLHttpRequest();
    var formada = new FormData();
    formada.append('id', pistaId)
    formada.append('pista', pista)
    formada.append('ginID', ginID)
    await formada.append('latitud',activemark[0].getPosition().lat())
    await formada.append('longitud',activemark[0].getPosition().lng())
    await formada.append('longitud',activemark[0].getPosition().lng())
    ajax.open('post', "./savePista");
    ajax.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    ajax.onload = function () {
        console.log(ajax.responseText)
    }
    ajax.send(formada);
}



async function deletePista(pistaId, pista){

    const allPoints=document.getElementsByClassName('point-span')
    let points=[]
    for (let i=0; i<allPoints.length;i++){
        points.push(allPoints[i].getAttribute('value'))
    }
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const ginID= document.getElementById('ginID').value
    var ajax = new XMLHttpRequest();
    var formada = new FormData();
    formada.append('id', pistaId)
    formada.append('pista', pista)
    formada.append('ginID', ginID)
    formada.append('points', points)
    await formada.append('latitud',activemark[0].getPosition().lat())
    await formada.append('longitud',activemark[0].getPosition().lng())
    await formada.append('longitud',activemark[0].getPosition().lng())
    ajax.open('post', "./deletePista");
    ajax.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    ajax.onload = function () {
        console.log(ajax.responseText)
    }
    ajax.send(formada);
}











// CODIGO MAPA

//////////////////////////////////////////////////////////////////////////////////////////////////77




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
