/**
 * Control de desplegables
 */
const headersDeplegables = document.getElementsByClassName('menu-detalles-sala-header');
const contenidosDeplegables = document.getElementsByClassName('menu-detalles-sala-contenidos');

function mostrarElemento(el) {
    el.style.display = 'block';
    el.dataset.status = "activo";
}

function esconderElemento(el) {
    el.style.display = 'none';
    el.dataset.status = "inactivo";
}

// Abrir elementos por defecto
for (let i = 0; i < headersDeplegables.length; i++) {
    headersDeplegables[i].dataset.status = "activo";
}

for (let i = 0; i < contenidosDeplegables.length; i++) {
    mostrarElemento(contenidosDeplegables[i]);
}

// Mostrar elemento al clickar en su header
for (let i = 0; i < headersDeplegables.length; i++) {
    headersDeplegables[i].addEventListener('click', (e) => {
        // Encontrar contenido asociado 
        let contenido;
        for (let j = 0; j < contenidosDeplegables.length; j++) {
            if (contenidosDeplegables[j].dataset.menuid == headersDeplegables[i].dataset.menuid) { // Si el menuID del header y el desplegable coinciden, es el contenido asociado
                contenido = contenidosDeplegables[j];
                break;
            }
        }

        // Esconder/mostrar contenido
        if (headersDeplegables[i].dataset.status == "activo") {
            esconderElemento(contenido);
            headersDeplegables[i].dataset.status = "inactivo";

            // Cambiar icono del header
            let iconoHeader = headersDeplegables[i].getElementsByClassName('menu-detalles-header-icon')[0];
            iconoHeader.classList.replace('fa-chevron-down', 'fa-chevron-up');
        } else if (headersDeplegables[i].dataset.status == "inactivo") {
            mostrarElemento(contenido);
            headersDeplegables[i].dataset.status = "activo";

            // Cambiar icono del header
            let iconoHeader = headersDeplegables[i].getElementsByClassName('menu-detalles-header-icon')[0];
            iconoHeader.classList.replace('fa-chevron-up', 'fa-chevron-down');
        }

    });
}

/**
 * Control apartado compartir
 */
const botonCopiarLink = document.getElementById('menu-info-sala-item-compartir-link');
const qrCompartir = document.getElementById('qr-compartir');

// Copiar url y mostrar aviso de copiado en portapapeles
botonCopiarLink.addEventListener('click', (e) => {
    navigator.clipboard.writeText(botonCopiarLink.dataset.url);

    let avisoCopiado = botonCopiarLink.getElementsByClassName('aviso-copiado')[0];
    avisoCopiado.style.transitionDuration = '10ms';
    avisoCopiado.style.color = 'black';
    setTimeout((e) => {
        avisoCopiado.style.transitionDuration = '2s';
        avisoCopiado.style.color = 'transparent';
    }, 2000);
});

// Cargar codigo QR
new QRCode(qrCompartir, botonCopiarLink.dataset.url);

/**
 * Control para unirse/abandonar la sala
 */

const formAcceso = document.getElementById('form-sala-acceso')
const botonAcceso = document.getElementById('menu-sala-unirse');

botonAcceso.addEventListener('click', (e) => {
    formAcceso.submit();
})