const gincanasContainer = document.getElementById('menu-gincanas');

const formGincanasFiltrar = document.getElementById('menu-gincanas-filtros');
const formGincanasFind = document.getElementById('form-gincanas-find');

const inputFiltrarNombre = document.getElementById('menu-gincanas-filtro-nombre');
const botonFiltrarPropiasToggle = document.getElementById('gincana-propia-toggle');

function listar(filtro, propias = 'false') {
    let formData = new FormData(formGincanasFiltrar);
    formData.append('filtro', filtro);
    formData.append('propias', propias);

    const ajax = new XMLHttpRequest();

    ajax.open('POST', formGincanasFiltrar.action);

    ajax.onload = function() {
        if (ajax.status == 200) {
            let gincanas = JSON.parse(ajax.response);

            // Limpiar gincanas actuales
            gincanasContainer.innerHTML = "";

            for (let i = 0; i < gincanas.length; i++) {
                let box = document.createElement('div');
                box.className = "boton-menu-principal gincana-contenedor localizacion-guardada";

                // Icono de la gincana
                let icono = document.createElement('i');
                icono.className = "fa-solid fa-map-location-dot";
                box.appendChild(icono);

                // Datos de la gincana
                let datos = document.createElement('div');
                datos.className = "gincana-datos";
                datos.innerText = gincanas[i].nombre;

                //      Nombre del autor de la gincana
                let autor = document.createElement('p');
                autor.className = "gincana-autor loc-coordenadas";
                autor.innerText = gincanas[i].autor.name;
                datos.appendChild(autor);

                box.appendChild(datos);

                // Event listener para acceder a la gincana
                box.addEventListener('click', (e) => {
                    window.location.href = formGincanasFind.action + '/' + gincanas[i].id;
                });

                gincanasContainer.appendChild(box);
            }

        } else {
            resultado.innerText = 'Error';
        }
    }

    ajax.send(formData);
}

function activarFiltroToggle(el) {
    el.classList.replace('boton-toggle-inactivo', 'boton-toggle-activo');
    el.dataset.activo = "true";
}

function desactivarFiltroToggle(el) {
    el.classList.replace('boton-toggle-activo', 'boton-toggle-inactivo');
    el.dataset.activo = "false";
}

listar('');

// Prevenir el submit del formulario de filtros
formGincanasFiltrar.addEventListener('submit', (e) => {
    e.preventDefault();
});

// Filtrar las gincanas del usuario
botonFiltrarPropiasToggle.addEventListener('click', (e) => {
    inputFiltrarNombre.value = null;
    if (botonFiltrarPropiasToggle.dataset.activo == "true") {
        desactivarFiltroToggle(botonFiltrarPropiasToggle);
    } else {
        activarFiltroToggle(botonFiltrarPropiasToggle);
    }
    listar(inputFiltrarNombre.value, botonFiltrarPropiasToggle.dataset.activo);
})

// Filtrar gincanas según nombre
inputFiltrarNombre.addEventListener('input', (e) => {
    listar(inputFiltrarNombre.value, botonFiltrarPropiasToggle.dataset.activo);
})