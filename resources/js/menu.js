const menuPrincipal = document.getElementById('menu-principal');
const botonMenu = document.getElementById('menu-button');
const botonAtrasMenu = document.getElementById('menu-principal-boton-atras');

// Mover el menú al centro de la pantalla
function abrirMenu() {
    menuPrincipal.style.transform = "translateX(0px)";
}

// Mover el menú fuera de la pantalla
function cerrarMenu() {
    menuPrincipal.style.transform = "translateX(" + getComputedStyle(menuPrincipal).width + ")";
}

// Abrir menú al pulsar botón
botonMenu.addEventListener('click', (e) => {
    abrirMenu();
});

// Cerrar menú al pulsar botón
botonAtrasMenu.addEventListener('click', (e) => {
    cerrarMenu();
});