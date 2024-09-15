
const expresiones = {
    soloNumeros: /^[0-9,.]+$/  // solo se permite numeros
}

const estadoInput = {
    numHabitacion: false,
    tipoHab: false,
    observaciones: false,
    sisClimatizacion: false,
    tipoCama: false,
    cantCamasTotales: false,
    numHabitacionEdit: false,
    observacionesEdit: false
}

//! VALIDAR LOS CAMPOS DEL FORMULARIO DE REGISTRO DE HAITACIONES

const formulario = document.getElementById('formRegHab');
const inputForm = document.querySelectorAll('#formRegHab input');
const selectDato = document.querySelectorAll('#formRegHab select');
const obsTextarea = document.querySelectorAll('#formRegHab textarea');
const modalNfc = document.getElementById('registrarNfc');
const inputCodNfc = document.getElementById('codNfc');

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

    if (vInput === 0) {
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

function showModal(){
    let myModal = new bootstrap.Modal(modalNfc);
    myModal.show();

    modalNfc.addEventListener('shown.bs.modal', function () {
        inputCodNfc.focus();
    });
}

// VALIDAR PARTE DE LOS TIPOS DE CAMAS

formulario.addEventListener('submit', (e) => {

    let inputCheck = document.querySelectorAll(".tiposDeCamas input:checked"); // checkbox a los tipos de camas


    const cantidadCamasElementos = document.querySelectorAll(".cantidadCamas");
    let valoresCantidadCamas = []; // Crear un array para almacenar los valores
    const cantidadCamasBD = document.querySelectorAll(".mensajeCantidad"); // cantidad de las camas que estan registradas en la BD
    let numCantCamas;

    cantidadCamasBD.forEach(function (e) {
        let textoCantCamas = e.textContent; //numero total de la cantidad de camas
        numCantCamas = parseInt(textoCantCamas.match(/\d+/g));
    })


    // Recorrer los elementos de cantidadCamasElementos
    cantidadCamasElementos.forEach(function (elemento) {
        let valor = parseInt(elemento.value, 10); // Parsear el valor a entero
        if (!isNaN(valor)) {
            valoresCantidadCamas.push(valor); // Agregar el valor al arreglo si es un número válido
        }
    });

    // Calcular la suma total
    let sumaTotal = 0;
    valoresCantidadCamas.forEach(function (valor) {
        sumaTotal += valor;
    });

    let errorCantCamas = false;

    if (sumaTotal == numCantCamas) {
        estadoInput['cantCamasTotales'] = true;
    } else {
        errorCantCamas = true;
    }


    e.preventDefault(); // No dejar enviar el formulario

    if (estadoInput.numHabitacion && estadoInput.tipoHab && estadoInput.sisClimatizacion && estadoInput.observaciones && inputCheck.length >= 1 && estadoInput.cantCamasTotales) {
        showModal();
        //formulario.submit();
    } else {

        if (errorCantCamas) {
            document.getElementById("msjErrorTipoCama2").style.display = "block";
            document.querySelector(".formularioMensaje").classList.add("activoMensaje");
        } else {
            document.getElementById("msjErrorTipoCama").style.display = "block";
            document.querySelector(".formularioMensaje").classList.add("activoMensaje");
        }
    }

});

/* const btnAdd = document.getElementById('btn-add');

btnAdd.addEventListener('click', (e) => {

    e.preventDefault(); // No dejar enviar el formulario

    let inputCheck = document.querySelectorAll(".tiposDeCamas input:checked"); // checkbox a los tipos de camas


    const cantidadCamasElementos = document.querySelectorAll(".cantidadCamas");
    let valoresCantidadCamas = []; // Crear un array para almacenar los valores
    const cantidadCamasBD = document.querySelectorAll(".mensajeCantidad"); // cantidad de las camas que estan registradas en la BD
    let numCantCamas;

    cantidadCamasBD.forEach(function (e) {
        let textoCantCamas = e.textContent; //numero total de la cantidad de camas
        numCantCamas = parseInt(textoCantCamas.match(/\d+/g));
    })


    // Recorrer los elementos de cantidadCamasElementos
    cantidadCamasElementos.forEach(function (elemento) {
        let valor = parseInt(elemento.value, 10); // Parsear el valor a entero
        if (!isNaN(valor)) {
            valoresCantidadCamas.push(valor); // Agregar el valor al arreglo si es un número válido
        }
    });

    // Calcular la suma total
    let sumaTotal = 0;
    valoresCantidadCamas.forEach(function (valor) {
        sumaTotal += valor;
    });

    let errorCantCamas = false;

    if (sumaTotal == numCantCamas) {
        estadoInput['cantCamasTotales'] = true;
    } else {
        errorCantCamas = true;
    }

    if (estadoInput.numHabitacion && estadoInput.tipoHab && estadoInput.sisClimatizacion && estadoInput.observaciones && inputCheck.length >= 1 && estadoInput.cantCamasTotales) {
        console.log("nice");
        
        //formulario.submit();
    } else {

        if (errorCantCamas) {
            document.getElementById("msjErrorTipoCama2").style.display = "block";
            document.querySelector(".formularioMensaje").classList.add("activoMensaje");
        } else {
            document.getElementById("msjErrorTipoCama").style.display = "block";
            document.querySelector(".formularioMensaje").classList.add("activoMensaje");
        }
    }

}) */