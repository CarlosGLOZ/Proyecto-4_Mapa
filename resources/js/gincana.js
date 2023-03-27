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