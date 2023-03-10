var csrf_token = document.getElementById('_token').content;
window.onload= function (){
    let button = document.getElementById("button");
    button.addEventListener('click', function (e){
        listar('');
    })
}


function listar(filtro) {
    let resultado = document.getElementById("div1");
    let formdata = new FormData();
     formdata.append('_token', csrf_token);
    formdata.append('filtro', filtro);
    const ajax = new XMLHttpRequest();
    ajax.open('POST', 'listar');
    ajax.onload = function() {

        if (ajax.status == 200) {
            let admins = JSON.parse(ajax.responseText);
            let box = '';
            admins.forEach(element => {
                box += ` <div class="container" >
        <div id="resultado">
        </div>
    <p >${element.nombre}</p>
    </div>`;
            });
            resultado.innerHTML = box;

        } else {
            resultado.innerText = 'Error';
        }
    }
    ajax.send(formdata);

}



let buscar = document.getElementById("buscar");

buscar.addEventListener("keyup", () => {
    let filtro = buscar.value;
    console.log(filtro);
    if (filtro == "") {
        listar('');
    }else {
        listar(filtro);
    }
});
