const menuPrincipal = document.getElementById('menu-principal');
const botonesBDD = document.getElementsByClassName('boton-loc-bdd');
const menuPrincipalBotones = document.getElementById('menu-principal-botones');

const formularioLocFind = document.getElementById('formulario-loc-find');
const formStoreLike = document.getElementById('form-store-like');
const formDestroyLike = document.getElementById('form-destroy-like');
const formAsyncLikes = document.getElementById('form-async-likes');

const menuLocalizacion = document.getElementById('menu-localizacion');
const menuBotonfav = document.getElementById('menu-localizacion-botonfav');
const menuBotoncerrar = document.getElementById('menu-localizacion-botoncerrar');

// Devuelve un punto de la base de datos mediante un ID
function getPuntoBDD(id, callback) {
    let formData = new FormData(formularioLocFind);
    formData.append('locID', id);

    const ajax = new XMLHttpRequest();

    ajax.open('POST', formularioLocFind.action);

    ajax.onload = (e) => {
        if (ajax.status == 200) {
            let punto = JSON.parse(ajax.response);
            callback(punto);
            // console.log(punto);
        }
    }

    ajax.send(formData);
}

// Esta es la misma funcion que "abrirMenu()" en "mapa.js"
function abrirMenuLocalizacion(punto) {
    // Cerrar menú preventivamente
    menuLocalizacion.style.transform = "translate(-390px)";

    let menuImagenWrapper = document.getElementById('menu-localizacion-imagen-wrapper');
    let menuTitulo = document.getElementById('menu-localizacion-titulo');
    let menuAutor = document.getElementById('menu-localizacion-autor');
    let menuDescripcion = document.getElementById('menu-localizacion-descripcnfavion');
    let menuDireccion = document.getElementById('menu-localizacion-direccion');
    let menuTags = document.getElementById('menu-localizacion-tags');

    menuImagenWrapper.style.display = "none";
    menuTitulo.innerText = punto.nombre;
    menuAutor.innerText = punto.usuario.name;
    menuDescripcion.style.display = 'block';
    menuDescripcion.innerText = punto.descripcion;
    menuDireccion.innerText = punto.latitud + "º, " + punto.longitud + "º";
    menuBotonfav.dataset.id = punto.id;
    menuBotonfav.dataset.tipo = "BDD";

    // Añadir tags
    menuTags.innerHTML = '';
    for (let i = 0; i < punto.tags.length; i++) {
        let tagChip = document.createElement('p');
        tagChip.classList.add('tag-chip');
        tagChip.innerText = punto.tags[i].nombre;

        menuTags.appendChild(tagChip);
    }

    // Mostrar menu
    menuLocalizacion.style.transform = "translateY(0)";
}

// Abrir el menú para una localizacion del maps
function abrirMenuLocalizacionMaps(punto) {
    let menuImagenWrapper = document.getElementById('menu-localizacion-imagen-wrapper');
    let menuImagen = document.getElementById('menu-localizacion-imagen');
    let menuTitulo = document.getElementById('menu-localizacion-titulo');
    let menuAutor = document.getElementById('menu-localizacion-autor');
    let menuDescripcion = document.getElementById('menu-localizacion-descripcion');
    let menuDireccion = document.getElementById('menu-localizacion-direccion');
    let menuTags = document.getElementById('menu-localizacion-tags');

    // Cerrar menú preventivamente
    menuLocalizacion.style.transform = "translate(-390px)";

    menuImagenWrapper.style.display = "block";
    menuImagen.style.backgroundImage = "url(" + punto.photos[0].getUrl() + ')';
    menuTitulo.innerText = punto.name;
    menuAutor.innerText = 'Google Maps';
    menuDescripcion.style.display = 'none';
    menuDireccion.innerText = punto.formatted_address;
    menuBotonfav.dataset.id = punto.place_id;
    menuBotonfav.dataset.tipo = "Google Maps";

    // Añadir tags
    menuTags.innerHTML = '';
    let tagChip = document.createElement('p');
    tagChip.classList.add('tag-chip');
    tagChip.innerText = 'Google Maps';

    menuTags.appendChild(tagChip);

    // // Mostrar menu
    menuLocalizacion.style.transform = "translateY(0)";
}

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
                    console.log(ajax.response);
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

// Mostrar una localizacion del maps en el menu
function mostrarLocalizacionMaps(loc) {
    // Boton
    let boton = document.createElement('button');
    boton.className = "boton-menu-principal localizacion-guardada boton-loc-maps";

    // Icono
    let icon = document.createElement('i');
    icon.className = "fa-solid fa-map";
    boton.appendChild(icon);

    // div de datos
    let div = document.createElement('div');
    div.innerText = loc.name;

    let div2 = document.createElement('div');
    div2.className = 'loc-coordenadas';
    div2.innerText = loc.formatted_address;

    div.appendChild(div2)
    boton.appendChild(div)

    // Event listener para abrir el menu de localizacion
    boton.addEventListener('click', (e) => {
        abrirMenuLocalizacionMaps(loc);
    });

    menuPrincipalBotones.appendChild(boton);
}

// Recoger favoritos de la BDD para mostrar los puntos guardados de Google Maps
function getFavoritosBDD(callback) {
    const ajax = new XMLHttpRequest();

    ajax.open('GET', formAsyncLikes.action);

    ajax.onload = (e) => {
        if (ajax.status === 200) {
            let likes = JSON.parse(ajax.response);
            callback(likes, mostrarLocalizacionMaps);
        }
    }

    ajax.send();
}

// Get info de las localizaciones del maps en base a su ID
function getInfoLocalizacionMaps(likes, callback) {
    for (let i = 0; i < likes.length; i++) {
        // Si el like tiene un Id de localizacion del maps
        if (likes[i].localizacion_maps_id != "") {
            var service = new google.maps.places.PlacesService(document.createElement('div'));

            service.getDetails({
                placeId: likes[i].localizacion_maps_id,
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
                    callback(place);
                }
            });
        }
    }
}

// Mostrar favoritos de la base de datos
getFavoritosBDD(getInfoLocalizacionMaps);

for (let i = 0; i < botonesBDD.length; i++) {
    botonesBDD[i].addEventListener('click', (e) => {
        getPuntoBDD(botonesBDD[i].dataset.id, abrirMenuLocalizacion);
    });
}