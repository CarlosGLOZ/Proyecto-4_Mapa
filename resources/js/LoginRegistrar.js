 var SingUp = document.getElementById('SingUp');
 var LogIn = document.getElementById('LogIn');
 var LoginFormulario = document.getElementById('login');
 var RegistrarFormulario = document.getElementById('registrar');
 const inputs = LoginFormulario.querySelectorAll('input');
 const inputs2 = RegistrarFormulario.querySelectorAll('input');
 const botonEnviar = LoginFormulario.querySelector('#botonEnviar');
 const botonEnviar2 = RegistrarFormulario.querySelector('#botonEnviar2');

 SingUp.addEventListener("click", (e) => {
     LoginFormulario.style.display = "none";
     RegistrarFormulario.style.display = "flex";
     e.preventDefault();

 });

 LogIn.addEventListener("click", (e) => {
     LoginFormulario.style.display = "flex";
     RegistrarFormulario.style.display = "none";
     e.preventDefault();
 });



 /*Login*/
 // agregamos un event listener a cada input
 inputs.forEach(input => {
     input.addEventListener('input', () => {
         // verificamos si todos los inputs están llenos
         const todosLlenos = [...inputs].every(input => input.value.trim() !== '');

         // si todos están llenos, cambiamos el color del botón a verde
         // de lo contrario, lo dejamos como estaba
         if (todosLlenos) {
             botonEnviar.style.opacity = 1;

         } else {
             botonEnviar.style.opacity = 0.3;


         }
     });
 });



 /*Registrar*/
 // agregamos un event listener a cada input
 inputs2.forEach(input => {
     input.addEventListener('input', () => {
         // verificamos si todos los inputs están llenos
         const todosLlenos2 = [...inputs2].every(input => input.value.trim() !== '');

         // si todos están llenos, cambiamos el color del botón a verde
         // de lo contrario, lo dejamos como estaba
         if (todosLlenos2) {
             botonEnviar2.style.opacity = 1;

         } else {
             botonEnviar2.style.opacity = 0.3;
         }
     });
 });




 // Validación Login

 function validarFormulario() {
     var correo = document.forms["registrar"]["email"].value;
     var password = document.forms["registrar"]["password"].value;
     var password_confirmation = document.forms["registrar"]["password_confirmation"].value;
     var correoValido = validarCorreo(correo);
     var contrasenaValida = validaPassword(password);
     var confirmationValida = validaConfirmPassword(password, password_confirmation);
     if (correoValido && contrasenaValida && confirmationValida) {

         return true;
     } else {

         return false;
     }
 }

 function validarCorreo(correo) {
     var expresion = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
     if (expresion.test(correo)) {
         return true;
     } else {
         alert("Correo electrónico inválido");
         return false;
     }
 }

 function validaPassword(password) {
     var expresion = /[A-Z]/;
     // Longitud mínima de 8 caracteres y letra mayúscula
     if (expresion.test(password) && password.length > 8) {
         return true;
     } else {
         alert("Contraseña inválida");
         return false;
     }

 }

 function validaConfirmPassword(password, password_confirmation) {
     // Comprobación contraseñas
     if (password == password_confirmation) {
         return true;
     } else {
         alert("Las Contraseñas no coinciden");
         return false;
     }

 }