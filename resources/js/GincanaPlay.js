const mainHome = document.getElementById('main-home');
const mapaMain = document.getElementById('mapa-main');
let mapa;
const iconoMarcador = "ruta/de/la/imagen.png";

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
        icon: iconoMarcador
    });

    // Establecer el centro de la pantalla como la posicion del usuario
    navigator.geolocation.getCurrentPosition((position) => {
        map.setCenter({ lat: position.coords.latitude, lng: position.coords.longitude });
    });

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

            // Reestablecer posicion del usuario en el mapa
            marcadorUsuario.setPosition(userPos);
        },
        () => {
            // Error callback
        });
}




//Animacion check-button
const check = document.getElementById('check-button');
const pista = document.getElementById('pista');

check.addEventListener("click", () => {
    pista.style.display = "flex";
});