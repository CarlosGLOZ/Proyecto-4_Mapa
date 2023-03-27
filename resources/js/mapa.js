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

const menuLocalizacionCrear = document.getElementById('menu-localizacion-crear');
const menuBotonfavCrear = document.getElementById('menu-localizacion-crear-botonfav');
const menuBotoncerrarCrear = document.getElementById('menu-localizacion-crear-botoncerrar');

const botonToggleFavoritos = document.getElementById('mapa-fav-toggle');

// Activar boton de like
function activarLike(boton) {
    boton.style.color = '#e4e100';
    boton.classList.replace('fa-regular', 'fa-solid');
}

// Desactivar boton de like
function desactivarLike(boton) {
    boton.style.color = 'black';
    boton.classList.replace('fa-solid', 'fa-regular');
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
        formData.append('localizacion_id', punto.id);
        formData.append('tipo_localizacion', 'BDD');

        let ajax = new XMLHttpRequest();
        ajax.open('POST', formGetLiked.action);

        ajax.onload = (e) => {
            if (ajax.status === 200) {
                console.log({
                    'response': ajax.response
                });
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
        menuImagenWrapper.style.display = "block";
        menuImagen.style.backgroundImage = "url(" + punto.photos[0].getUrl() + ')';
        menuTitulo.innerText = punto.name;
        menuAutor.innerText = 'Google Maps';
        menuDescripcion.style.display = 'none';
        menuDireccion.innerText = punto.formatted_address;
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
                console.log({
                    'response': ajax.response
                });
                if (ajax.response == true) {
                    // El usuario le ha dado a like al punto de interés
                    menuBotonfav.dataset.action = 'removeLike';
                    menuBotonfav.dataset.tipo = 'Google Maps';
                    // menuBotonfav.classList.replace('fa-solid', 'fa-regular');
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

// Abrir menu con info del punto creado por el usuario
function abrirMenuPuntoUsuario(punto) {
    let menuImagenWrapper = document.getElementById('menu-localizacion-crear-imagen-wrapper');
    let menuTitulo = document.getElementById('menu-localizacion-crear-titulo');
    let menuDescripcion = document.getElementById('menu-localizacion-crear-descripcion');
    let menuDireccion = document.getElementById('menu-localizacion-crear-direccion');
    let latitud = document.getElementById('menu-localizacion-crear-input-latitud');
    let longitud = document.getElementById('menu-localizacion-crear-input-longitud');

    // Limpiar los datos de los inputs
    menuTitulo.value = '';
    menuDescripcion.value = '';

    // Distinguir entre si es un punto del maps o de la BDD
    menuImagenWrapper.style.display = "none";
    menuDescripcion.style.display = 'block';
    menuDireccion.innerText = punto.getPosition().lat().toFixed(5) + "º, " + punto.getPosition().lng().toFixed(5) + "º";
    latitud.value = punto.getPosition().lat();
    longitud.value = punto.getPosition().lng();

    // El usuario no le ha dado a like al punto de interés
    menuBotonfavCrear.dataset.action = 'addLike';
    menuBotonfavCrear.dataset.tipo = 'NUEVO';
    desactivarLike(menuBotonfavCrear);

    // Mostrar menu
    menuLocalizacionCrear.style.transform = "translateY(0)";
}

function cerrarMenus() {
    menuLocalizacion.style.transform = "translate(-390px)";
    menuLocalizacionCrear.style.transform = "translate(-390px)";
}

// Cerrar el menu
menuBotoncerrar.addEventListener('click', (e) => {
    cerrarMenus();
});

// Cerrar el menu de crear
menuBotoncerrarCrear.addEventListener('click', (e) => {
    cerrarMenus();
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

                    console.log(response);

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

                    if (response.status == 'OK') {
                        // Se ha puesto el like, cambiar el botón
                        menuBotonfav.dataset.action = 'addLike';
                        desactivarLike(menuBotonfav);
                        cerrarMenus();
                    }
                }
            }

            ajax.send(formData);

            menuBotonfav.dataset.action == 'addLike';
        }
    }
});

// Añadir/quitar favorito de punto del usuario
menuBotonfavCrear.addEventListener('click', (e) => {
    // Si el usuario no está logueado, mandar a la pagina de login
    if (!auth) {
        window.location.href = "auth/LoginRegistrar";
    } else {
        let nombre = document.getElementById('menu-localizacion-crear-titulo');
        let descripcion = document.getElementById('menu-localizacion-crear-descripcion');
        let latitud = document.getElementById('menu-localizacion-crear-input-latitud');
        let longitud = document.getElementById('menu-localizacion-crear-input-longitud');

        // Validaciones
        if (nombre.value.trim() == '') {
            nombre.style.borderColor = "rgb(212, 59, 59)";
            return;
        } else {
            nombre.style.borderColor = "black";
        }

        if (descripcion.value.trim() == '') {
            descripcion.style.borderColor = "rgb(212, 59, 59)";
            return;
        } else {
            descripcion.style.borderColor = "black";
        }

        // Mandar peticion de añadir favorito
        let formData = new FormData(formStoreLike);
        formData.append('tipo_localizacion', menuBotonfavCrear.dataset.tipo);
        formData.append('nombre', nombre.value);
        formData.append('descripcion', descripcion.value);
        formData.append('latitud', latitud.value);
        formData.append('longitud', longitud.value);

        let ajax = new XMLHttpRequest();

        ajax.open('POST', formStoreLike.action);

        ajax.onload = (e) => {
            if (ajax.status === 200) {
                let response = JSON.parse(ajax.response);

                if (response.status == 'OK') {
                    // Se ha puesto el like, cerrar menu y añadir marcador
                    cerrarMenus();
                }
            }
        }

        ajax.send(formData);
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

    // Punto de interés creado por el usuario
    let puntoUsuario = new google.maps.Marker({
        map,
        visible: false
    });;

    // Añadir un event listener para cuando el usuario clica en un Punto de Interés
    map.addListener('click', (e) => {
        var lat = e.latLng.lat();
        var lng = e.latLng.lng();
        var poi = e.placeId;

        // Asegurarse que los menús están cerrados
        cerrarMenus();

        if (poi) { // El usuario ha clicado un punto de interés, mostrar menú con la info
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

        } else { // El usuario ha clicado en un punto del mapa sin punto de interés
            // Recolocar el punto creado por el usuario
            puntoUsuario.setPosition({ lat: lat, lng: lng });
            puntoUsuario.setVisible(true);

            abrirMenuPuntoUsuario(puntoUsuario);
        }
    });

    // Añadir marcadores de este usuario de la BDD al mapa
    let ajax = new XMLHttpRequest();

    ajax.open('GET', formGetLocalizaciones.action);

    ajax.onload = (e) => {
        if (ajax.status === 200) {
            let puntos = JSON.parse(ajax.response);

            let marcadores = [];

            // Mostrar puntos en el mapa
            for (let i = 0; i < puntos.length; i++) {
                let punto = new google.maps.Marker({
                    map,
                    title: puntos[i].nombre,
                    position: { lat: parseFloat(puntos[i].latitud), lng: parseFloat(puntos[i].longitud) }
                });

                marcadores.push(punto);

                punto.setVisible(false);

                punto.addListener('click', (e) => {
                    // Menu con info aquí
                    abrirMenu(puntos[i]);
                })
            }

            // Event listener para mostrarlos
            botonToggleFavoritos.addEventListener('click', (e) => {
                if (botonToggleFavoritos.dataset.set == 'hidden') {
                    for (let i = 0; i < marcadores.length; i++) {
                        marcadores[i].setVisible(true);
                    }
                    botonToggleFavoritos.dataset.set = 'shown';
                    activarLike(botonToggleFavoritos);
                } else if (botonToggleFavoritos.dataset.set == 'shown') {
                    for (let i = 0; i < marcadores.length; i++) {
                        marcadores[i].setVisible(false);
                    }
                    botonToggleFavoritos.dataset.set = 'hidden';
                    desactivarLike(botonToggleFavoritos);
                }
            });
        }
    }

    ajax.send()


    // Guardar la posicion del usuario en un objeto en localstorage
    const userPos = {
        lat: "",
        lng: "",
    };

    // Actualizar la posicion del usuario en el mapa
    const watchId = navigator.geolocation.watchPosition((position) => {
            // Success callback

            // Cambiar la posicion del usuario
            userPos.lat = position.coords.latitude
            userPos.lng = position.coords.longitude

            // Reestablecer posicion del usuario en el mapa
            marcadorUsuario.setPosition(userPos);
        },
        () => {
            // Error callback
        });
}