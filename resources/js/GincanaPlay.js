const mainHome = document.getElementById('main-home');
const mapaMain = document.getElementById('mapa-main');
const formGetGincana = document.getElementById('form-get-puntos');


//Esta función compara la localización del usuario con la de los puntos de la Gincana
function ComprobaciónCheck(userPos, puntoPos) {


    //Latitud Puntos
    let LatResta = Math.abs(puntoPos.lat - userPos.lat);


    let LonResta = Math.abs(puntoPos.lon - userPos.lng);


    if (LatResta <= 0.001 && LonResta <= 0.0005) {
        Swal.fire({
            icon: 'success',
            title: 'Correcto',
            background: 'White',
            text: 'Estas en la ubicación correcta',
            footer: '<a href="">Adelante a por la siguiente</a>'
        })
        return true;
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            background: 'White',
            text: 'No estas en la ubicación correcta',
            footer: '<a href="">Prueba otra Vez</a>'
        })
        return false;
    }
}

let mapa;

// Initialize and add the map
function initMap() {
    // The map
    const map = new google.maps.Map(mapaMain, {
        zoom: 15,
        center: { lat: 0, lng: 0 },
        disableDefaultUI: true,
    });

    // Marcador de usuario
    const marcadorUsuario = new google.maps.Marker({
        map,

    });

    // Establecer el centro de la pantalla como la posicion del usuario
    navigator.geolocation.getCurrentPosition((position) => {
        map.setCenter({ lat: position.coords.latitude, lng: position.coords.longitude });
    });


    //Establecer el centro de 

    //Recoger Info de la Gincana
    const ajax = new XMLHttpRequest();
    ajax.open('GET', formGetGincana.action);

    ajax.onload = (e) => {

        if (ajax.status === 200) {
            let gincana = JSON.parse(ajax.response);
            const pista = document.getElementById('pista');
            const desplegable = document.getElementById('desplegable');
            const pista_texto = document.getElementById('pista-texto');
            const jugador = document.getElementById('jugador');
            jugador.innerHTML = gincana.autor.name;
            const nombreGincana = document.getElementById('Nombre_Gincana');
            nombreGincana.innerHTML = gincana.nombre;
            var ContadorPista = 0;
            var ContadorTotalPuntos = gincana.puntos.length;
            var ContadorDesplegable = 0;


            //Animacion aparición pista
            const check = document.getElementById('check-button');

            function Pista(ContadorPista) {
                pista_texto.innerHTML = gincana.puntos[ContadorPista].pista;
                pista.style.display = "flex";
            }


            let puntoPos = {};
            puntoPos.lat = gincana.puntos[0].localizacion.latitud;
            puntoPos.lon = gincana.puntos[0].localizacion.longitud;

            pista.addEventListener("click", () => {

                if (ContadorDesplegable == '0') {
                    desplegable.style.display = "flex";
                    ContadorDesplegable = 1;

                } else {
                    desplegable.style.display = "none";
                    ContadorDesplegable = 0
                }


            });

            check.addEventListener("click", (e) => {
                pista.style.display = "none";
                let userPos = {
                    'lat': document.getElementById('check-button').dataset.userLat,
                    'lng': document.getElementById('check-button').dataset.userLng
                };
                let check = ComprobaciónCheck(userPos, puntoPos);
                if (check) {
                    ContadorPista = ContadorPista + 1;
                }

                if (ContadorPista !== ContadorTotalPuntos) {
                    setTimeout((e) => {
                        Pista(ContadorPista)
                    }, 'delay', 3000)
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Enorabuena has completado la Gincana',
                        showConfirmButton: false,
                        timer: 1500
                    })

                }


            });

            window.onload = function() {
                Pista(ContadorPista);

            }

            // Actualizar la posicion del usuario en el mapa
            const watchId = navigator.geolocation.watchPosition((position) => {
                    // Success callback

                    // Guardar la posicion del usuario en un objeto en localstorage
                    const userPos = {
                        lat: "",
                        lng: "",
                    };

                    userPos.lat = position.coords.latitude
                    userPos.lng = position.coords.longitude

                    check.dataset.userLat = userPos.lat;
                    check.dataset.userLng = userPos.lng;

                    // Reestablecer posicion del usuario en el mapa
                    marcadorUsuario.setPosition(userPos);

                },
                () => {
                    // Error callback
                });


        }
    }

    ajax.send();


}