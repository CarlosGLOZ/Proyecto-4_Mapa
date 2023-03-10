const mainHome = document.getElementById('main-home');
const mapaMain = document.getElementById('mapa-main');
let mapa;

const formGetLocalizaciones = document.getElementById('form-get-localizaciones');
const formGetLiked = document.getElementById('form-get-liked');
const formStoreLike = document.getElementById('form-store-like');
const formDestroyLike = document.getElementById('form-destroy-like');

const menuLocalizacion = document.getElementById('menu-localizacion');
const menuBotonfav = document.getElementById('menu-localizacion-botonfav');
const menuBotoncerrar = document.getElementById('menu-localizacion-botoncerrar');

// Activar boton de like
function activarLike(boton) {
    console.log('activado');
    boton.style.color = '#e4e100';
    menuBotonfav.classList.replace('fa-regular', 'fa-solid');
}

// Desactivar boton de like
function desactivarLike(boton) {
    console.log('desactivado');
    boton.style.color = 'black';
    menuBotonfav.classList.replace('fa-solid', 'fa-regular');
}

// Abrir menu con info del marcador dado
function abrirMenu(punto) {
    let menuImagenWrapper = document.getElementById('menu-localizacion-imagen-wrapper');
    let menuImagen = document.getElementById('menu-localizacion-imagen');
    let menuTitulo = document.getElementById('menu-localizacion-titulo');
    let menuAutor = document.getElementById('menu-localizacion-autor');
    let menuDescripcion = document.getElementById('menu-localizacion-descripcion');
    let menuDireccion = document.getElementById('menu-localizacion-direccion');
    let menuTags = document.getElementById('menu-localizacion-tags');

    // Distinguir entre si es un punto del maps o de la BDD
    if (punto.nombre) { // si tiene el atributo 'nombre' será un punto que viene desde la BDD
        menuImagenWrapper.style.display = "none";
        menuTitulo.innerText = punto.nombre;
        menuAutor.innerText = punto.usuario.name;
        menuDescripcion.style.display = 'block';
        menuDescripcion.innerText = punto.descripcion;
        menuDireccion.innerText = punto.latitud + "º, " + punto.longitud + "º";
        menuBotonfav.dataset.id = punto.id;

        // Añadir tags
        menuTags.innerHTML = '';
        for (let i = 0; i < punto.tags.length; i++) {
            let tagChip = document.createElement('p');
            tagChip.classList.add('tag-chip');
            tagChip.innerText = punto.tags[i].nombre;

            menuTags.appendChild(tagChip);
        }

        // Comprobar si el usuario le ha dado like a este punto
        let formData = new FormData(formGetLiked);
        formData.append('localizacion_id', punto.nombre);
        formData.append('tipo_localizacion', 'BDD');

        let ajax = new XMLHttpRequest();
        ajax.open('POST', formGetLiked.action);

        ajax.onload = (e) => {
            if (ajax.status === 200) {
                if (ajax.response == true) {
                    // El usuario le ha dado a like al punto de interés
                    menuBotonfav.dataset.action = 'removeLike';
                    menuBotonfav.dataset.tipo = 'BDD';
                    activarLike(menuBotonfav);
                } else {
                    // El usuario no le ha dado a like al punto de interés
                    menuBotonfav.dataset.action = 'addLike';
                    menuBotonfav.dataset.tipo = 'BDD';
                    desactivarLike(menuBotonfav);
                }
            }
        }

        ajax.send(formData);

        // Mostrar menu
        menuLocalizacion.style.transform = "translateY(0)";
    } else { // sino, será un punto que viene desde Google Maps
        // console.log(punto);
        menuImagenWrapper.style.display = "block";
        menuImagen.src = punto.photos[0].getUrl();
        menuTitulo.innerText = punto.name;
        menuAutor.innerText = 'Google Maps';
        menuDescripcion.style.display = 'none';

        // Parsear direccion
        let direccion = '';
        for (let i = 0; i < punto.address_components.length; i++) {
            if (i == punto.address_components.length - 1) {
                direccion = direccion + punto.address_components[i].short_name;
            } else {
                direccion = direccion + punto.address_components[i].short_name + ', ';
            }
        }

        menuDireccion.innerText = direccion;
        menuBotonfav.dataset.id = punto.place_id;

        // Añadir tags
        menuTags.innerHTML = '';
        let tagChip = document.createElement('p');
        tagChip.classList.add('tag-chip');
        tagChip.innerText = 'Google Maps';

        menuTags.appendChild(tagChip);

        // Comprobar si el usuario le ha dado like a este punto
        let formData = new FormData(formGetLiked);
        formData.append('localizacion_id', punto.place_id);
        formData.append('tipo_localizacion', 'Google Maps');

        let ajax = new XMLHttpRequest();
        ajax.open('POST', formGetLiked.action);

        ajax.onload = (e) => {
            if (ajax.status === 200) {
                if (ajax.response == true) {
                    // El usuario le ha dado a like al punto de interés
                    menuBotonfav.dataset.action = 'removeLike';
                    menuBotonfav.dataset.tipo = 'Google Maps';
                    menuBotonfav.classList.replace('fa-soli', 'fa-regular');
                    activarLike(menuBotonfav);
                } else {
                    // El usuario no le ha dado a like al punto de interés
                    menuBotonfav.dataset.action = 'addLike';
                    menuBotonfav.dataset.tipo = 'Google Maps';
                    desactivarLike(menuBotonfav);
                }
            }
        }

        ajax.send(formData);

        // // Mostrar menu
        menuLocalizacion.style.transform = "translateY(0)";
    }
}

// Cerrar el menu
menuBotoncerrar.addEventListener('click', (e) => {
    menuLocalizacion.style.transform = "translate(-390px)";
});

// Añadir/quitar favorito
menuBotonfav.addEventListener('click', (e) => {
    // Si el usuario no está logueado, mandar a la pagina de login
    if (!auth) {
        window.location.href = "auth/LoginRegistrar";
    } else {
        if (menuBotonfav.dataset.action == 'addLike') {
            // Mandar peticion de añadir favorito

            let formData = new FormData(formStoreLike);
            formData.append('id_localizacion', menuBotonfav.dataset.id);
            formData.append('tipo_localizacion', menuBotonfav.dataset.tipo);

            let ajax = new XMLHttpRequest();

            ajax.open('POST', formStoreLike.action);

            ajax.onload = (e) => {
                if (ajax.status === 200) {
                    let response = JSON.parse(ajax.response);

                    if (response.status == 'OK') {
                        // Se ha puesto el like, cambiar el botón
                        menuBotonfav.dataset.action = 'removeLike';
                        activarLike(menuBotonfav);
                    }
                }
            }

            ajax.send(formData);

            menuBotonfav.dataset.action == 'removeLike';
        } else if (menuBotonfav.dataset.action == 'removeLike') {
            // Mandar peticion de borrar favorito

            let formData = new FormData(formDestroyLike);
            formData.append('id_localizacion', menuBotonfav.dataset.id);
            formData.append('tipo_localizacion', menuBotonfav.dataset.tipo);

            let ajax = new XMLHttpRequest();

            ajax.open('POST', formDestroyLike.action);

            ajax.onload = (e) => {
                if (ajax.status === 200) {
                    let response = JSON.parse(ajax.response);
                    console.log(response.status);

                    if (response.status == 'OK') {
                        // Se ha puesto el like, cambiar el botón
                        menuBotonfav.dataset.action = 'addLike';
                        desactivarLike(menuBotonfav);
                    }
                }
            }

            ajax.send(formData);

            menuBotonfav.dataset.action == 'addLike';
        }
    }
});

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
        icon: "storage/img/iconos/user_icon.png",
    });

    // Establecer el centro de la pantalla como la posicion del usuario
    navigator.geolocation.getCurrentPosition((position) => {
        map.setCenter({ lat: position.coords.latitude, lng: position.coords.longitude });
    });

    // Añadir un event listener para cuando el usuario clica en un Punto de Interés
    map.addListener('click', (e) => {
        var lat = e.latLng.lat();
        var lng = e.latLng.lng();
        var poi = e.placeId;

        if (poi) {
            // El usuario ha clicado un punto de interés, mostrar menú con la info
            var service = new google.maps.places.PlacesService(map);

            service.getDetails({
                placeId: poi,
                fields: [
                    'address_component',
                    'adr_address',
                    'business_status',
                    'formatted_address',
                    'geometry',
                    'icon',
                    'name',
                    'photo',
                    'place_id',
                    'plus_code',
                    'type',
                    'url',
                    'vicinity',
                    'wheelchair_accessible_entrance'
                ],
            }, (place, status) => {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    // Menú con info aquí
                    abrirMenu(place);
                }
            });

        } else {
            // El usuario ha clicado en un punto del mapa sin punto de interés
            console.log('Clicked on map at: ' + lat + ', ' + lng);
        }
    });

    // Añadir marcadores de la BDD al mapa
    let ajax = new XMLHttpRequest();

    ajax.open('GET', formGetLocalizaciones.action);

    ajax.onload = (e) => {
        if (ajax.status === 200) {
            let puntos = JSON.parse(ajax.response);

            for (let i = 0; i < puntos.length; i++) {
                let punto = new google.maps.Marker({
                    map,
                    title: puntos[i].nombre,
                    position: { lat: 0, lng: 0 }
                });

                punto.addListener('click', (e) => {
                    // Menu con info aquí
                    abrirMenu(puntos[i]);
                })
            }
        }
    }

    ajax.send()

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