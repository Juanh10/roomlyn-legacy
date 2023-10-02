//! VALIDAR LOS CAMPOS DEL FORMULARIO DE REGISTRO DE HAITACIONES

const formulario = document.getElementById('formRegHab');
const inputForm = document.querySelectorAll('#formRegHab input');
const selectDato = document.querySelectorAll('#formRegHab select');
const obsTextarea = document.querySelectorAll('#formRegHab textarea');

const expresiones = {
    soloNumeros: /^[0-9,.]+$/  // solo se permite numeros
}

const estadoInput = {
    numHabitacion: false,
    tipoHab: false,
    observaciones: false,
    sisClimatizacion: false,
    tipoCama: false
}

const validarFormulario = (e) => {

    datoInput = e.target;
    nombreInput = e.target.name;

    switch (nombreInput) {
        case 'numHabitacion':
            validarCampo(expresiones.soloNumeros, datoInput, 'numHabitacion', 'Llena este campo con solo números');
            break;

        case 'tipoHab':
            validarSelect(datoInput, 'tipoHab', 'Debes escoger una opción');
            break;

        case 'sisClimatizacion':
            validarSelect(datoInput, 'sisClimatizacion', 'Debes escoger una opción');
            break;

        case 'observaciones':
            validarObser(datoInput, 'observaciones', 'Rellene este campo');
            break;
    }

}


const validarCampo = (expresion, input, idCampo, message) => {
    if (expresion.test(input.value)) {
        document.getElementById(idCampo).classList.remove("inputError");
        document.getElementById(idCampo).nextElementSibling.classList.remove("error"); // estoy accediendo al elemento hermano del input
        document.getElementById(idCampo).nextElementSibling.innerText = ""; // para agregar texto al elemento hermano del input
        estadoInput[idCampo] = true;
    } else {
        document.getElementById(idCampo).classList.add("inputError");
        document.getElementById(idCampo).nextElementSibling.classList.add("error"); // estoy accediendo al elemento hermano del input
        document.getElementById(idCampo).nextElementSibling.innerText = message; // para agregar texto al elemento hermano del input
        estadoInput[idCampo] = false;
    }
}

const validarSelect = (input, idCampo, message) => {
    let valorSelect = input.value;
    if (valorSelect === "") {
        document.getElementById(idCampo).classList.add("inputError");
        document.getElementById(idCampo).nextElementSibling.classList.add("error"); // estoy accediendo al elemento hermano del input
        document.getElementById(idCampo).nextElementSibling.innerText = message; // para agregar texto al elemento hermano del input
        estadoInput[idCampo] = false;
    } else {
        document.getElementById(idCampo).classList.remove("inputError");
        document.getElementById(idCampo).nextElementSibling.classList.remove("error"); // estoy accediendo al elemento hermano del input
        document.getElementById(idCampo).nextElementSibling.innerText = ""; // para agregar texto al elemento hermano del input
        estadoInput[idCampo] = true;
    }
}

const validarObser = (input, idCampo, message) => {

    let vInput = input.value.length;

    if(vInput === 0){
        document.getElementById(idCampo).classList.add("inputError");
        document.getElementById(idCampo).nextElementSibling.classList.add("error"); // estoy accediendo al elemento hermano del input
        document.getElementById(idCampo).nextElementSibling.innerText = message; // para agregar texto al elemento hermano del input
        estadoInput[idCampo] = false;
    }else{
        document.getElementById(idCampo).classList.remove("inputError");
        document.getElementById(idCampo).nextElementSibling.classList.remove("error"); // estoy accediendo al elemento hermano del input
        document.getElementById(idCampo).nextElementSibling.innerText = ""; // para agregar texto al elemento hermano del input
        estadoInput[idCampo] = true;
    }

}

inputForm.forEach((input) => {
    input.addEventListener('keyup', validarFormulario);
    input.addEventListener('blur', validarFormulario);
});

selectDato.forEach((select) => {
    select.addEventListener('blur', validarFormulario);
});

obsTextarea.forEach((textarea) => {
    textarea.addEventListener('keyup', validarFormulario);
    textarea.addEventListener('blur', validarFormulario);
})

formulario.addEventListener('submit', (e) =>{

    e.preventDefault(); // No dejar enviar el formulario

    if(estadoInput.numHabitacion && estadoInput.tipoHab && estadoInput.sisClimatizacion && estadoInput.observaciones){
        formulario.submit();
    }else{
        document.querySelector(".formularioMensaje").classList.add("activoMensaje");
    }

});