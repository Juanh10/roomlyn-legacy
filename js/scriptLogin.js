//*VER CONTRASEÑA
const contraseñaInput = document.querySelector("#pass");
const botonVer = document.querySelector(".verContraseña i");

botonVer.onclick = (() => {

    if(contraseñaInput.type === "password"){
        contraseñaInput.type = "text";
        botonVer.classList.add("bi-eye-slash");
        botonVer.classList.remove("bi-eye");
    }else{
        contraseñaInput.type = "password";
        botonVer.classList.remove("bi-eye-slash");
        botonVer.classList.add("bi-eye");
    }


});

//* VALIDACIONES FORMULARIO DEL LOGIN 

const usarioInput = document.querySelector('#user');
const contraInput = document.querySelector('#pass');
const form = document.querySelector('#form');

const validarFormulario = (message, input) => {
    const gValor = input.value.trim(); // Saber el valor del input


    if(gValor.length === 0){ //TODO Si la longitud del valor del input es 0 me muestra el mensaje de validacion
        input.classList.add("validarInput"); //TODO Agregarle una clase al input
        input.nextElementSibling.classList.add("error");//TODO agregarle una clase al hermano del input es decir a la etiqueta siguiente del input
        input.nextElementSibling.innerText = message; //TODO Parametro para escribir el mensaje de validacion
        return false; 
    }else{
        //* Bloque para quitar las clases de las etiquetas cuando la longitud es mayor a 0
        input.classList.remove("validarInput"); 
        input.nextElementSibling.classList.remove("error");
        input.nextElementSibling.innerText = "";
        return true;
    }
}

//* Llamar funcion con el evento blur para saber cuando ya no esta interactuando con el input y asi validar si el campo esta vacio

usarioInput.addEventListener("blur", (e) => validarFormulario("Llena este campo", e.target));
contraInput.addEventListener("blur", (e) => validarFormulario("Llena este campo ", e.target));

//* FUNCION PARA VALIDAR CUANDO SE LE DE CLIC AL BOTON DE INGRESAR

form.addEventListener("submit", (e) => {

    
    e.preventDefault();

    const usuValidado = validarFormulario("Llena este campo", usarioInput);
    const contraValidado = validarFormulario("Llena este campo", contraInput);

    if(usuValidado && contraValidado){
        form.submit();
    }

});


//! parentElement: es el label
//! insertAdjacentHTML: permite ingresar contenido HTML
//! blur: Evento cuando el cursor sale del campo
//! e: es un objeto que permite capturar toda la informacion
//! nextElementSibling: recoje el elemento hermano del input