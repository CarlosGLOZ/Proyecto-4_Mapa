window.onload= function (){
    alert('hola');
    let button = document.getElementById("button");
    button.addEventListener('click', function (e){
        listar();
    })
}


function listar() {
    var csrf_token = document.getElementById('token').content;

    alert('hola');
    let resultado = document.getElementById("resultado");
    let formdata = new FormData();
    formdata.append('_token', csrf_token);
    const ajax = new XMLHttpRequest();
    ajax.open('POST', 'listar');
    ajax.onload = function() {
        alert(ajax.responseText);
        if (ajax.status == 200) {
            let admins = JSON.parse(ajax.responseText);
            let box = '';
            admins.forEach(element => {
                box += `<p>${element.nombre}</p>`;
            });
            resultado.innerHTML = box;

        } else {
            resultado.innerText = 'Error';
        }
    }
    ajax.send(formdata);
}

listar('');

// buscar.addEventListener("keyup", () => {
//     let filtro = buscar.value;
//     if (filtro == "") {
//         listar('');
//     } else {
//         listar(filtro);
//     }
// });
