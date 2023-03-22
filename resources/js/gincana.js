const gincanasContainer = document.getElementById('menu-gincanas');

const formGincanasFiltrar = document.getElementById('menu-gincanas-filtros');
const formGincanasFind = document.getElementById('form-gincanas-find');

var csrf_token = document.getElementById('_token').content;
// window.onload = function() {
//     let button = document.getElementById("button");
//     button.addEventListener('click', function(e) {
//         listar('');
//     })
// }


function listar(filtro) {
    // let resultado = document.getElementById("div1");
    let formData = new FormData(formGincanasFiltrar);
    formData.append('filtro', filtro);

    const ajax = new XMLHttpRequest();

    ajax.open('POST', formGincanasFiltrar.action);

    ajax.onload = function() {
        if (ajax.status == 200) {
            let gincanas = JSON.parse(ajax.response);

            console.log(gincanas);
            for (let i = 0; i < gincanas.length; i++) {
                let box = document.createElement('div');
                box.className = "boton-menu-principal gincana-contenedor";

                // Icono de la gincana
                let icono = document.createElement('i');
                icono.className = "fa-solid fa-map-location-dot";
                box.appendChild(icono);

                // Datos de la gincana
                let datos = document.createElement('div');
                datos.className = "gincana-datos";

                //      Nombre de la gincana
                let nombre = document.createElement('p');
                nombre.className = "gincana-titulo";
                nombre.innerText = gincanas[i].nombre;
                datos.appendChild(nombre);

                //      Nombre del autor de la gincana
                let autor = document.createElement('p');
                autor.className = "gincana-autor";
                autor.innerText = gincanas[i].autor.name;
                datos.appendChild(nombre);

                box.appendChild(datos);

                // Event listener para acceder a la gincana
                box.addEventListener('click', (e) => {
                    window.location.href = formGincanasFind.action + '/' + gincanas[i].id;
                });

                gincanasContainer.appendChild(box);
            }

            // admins.forEach(element => {
            //     box += ` <div class="container" >
            //         <div id="resultado">
            //         </div>
            //     <p >${element.nombre}</p>

            //     </div>`;
            // });
            // resultado.innerHTML = box;

        } else {
            resultado.innerText = 'Error';
        }
    }

    ajax.send(formData);
}

listar('');

let buscar = document.getElementById("buscar");

buscar.addEventListener("keyup", () => {
    let filtro = buscar.value;
    console.log(filtro);
    if (filtro == "") {
        listar('');
    } else {
        listar(filtro);
    }
});