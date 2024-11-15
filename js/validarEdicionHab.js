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

const formularioEdit = document.getElementById('formEditarHab');
const inputFormEdit = document.querySelectorAll('#formEditarHab input');
const selectDatoEdit = document.querySelectorAll('#formEditarHab select');
const obsTextareaEdit = document.querySelectorAll('#formEditarHab textarea');

const validarFormulario = (e) => {

    datoInput = e.target;
    nombreInput = e.target.name;

    switch (nombreInput) {
        case 'numHabitacion':
            validarCampo(expresiones.soloNumeros, datoInput, 'numHabitacionEdit', 'Llena este campo con solo números');
            break;

        case 'observaciones':
            validarObser(datoInput, 'observacionesEdit', 'Rellene este campo');
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

inputFormEdit.forEach((input) => {
    input.addEventListener('keyup', validarFormulario);
    input.addEventListener('blur', validarFormulario);
});

selectDatoEdit.forEach((select) => {
    select.addEventListener('blur', validarFormulario);
});

obsTextareaEdit.forEach((textarea) => {
    textarea.addEventListener('keyup', validarFormulario);
    textarea.addEventListener('blur', validarFormulario);
});


// VALIDAR PARTE DE LOS TIPOS DE CAMAS

const modalNfc = document.getElementById('actualizarNFC');


// Función para validar las camas
const validarCamas = () => {
    let errorCantCamas = false;
    let inputCheck = document.querySelectorAll(".tiposDeCamasEdit input:checked"); // checkboxes seleccionados

    // Validar que al menos un checkbox está seleccionado
    if (inputCheck.length === 0) {
        errorCantCamas = true; // No se seleccionó ningún checkbox
    } else {
        const cantidadCamasElementos = document.querySelectorAll(".cantidadCamasEdit");
        let valoresCantidadCamas = []; // Crear un array para almacenar los valores de las camas
        const cantidadCamasBD = document.querySelectorAll(".mensajeCantidad"); // Cantidad de camas que están registradas en la BD
        let numCantCamas;

        cantidadCamasBD.forEach(function (e) {
            let textoCantCamas = e.textContent; // Obtiene el texto con la cantidad de camas
            numCantCamas = parseInt(textoCantCamas.match(/\d+/g)); // Extrae el número de camas
        });

        // Recorre los campos de cantidad de camas e ingresa los valores en un array
        cantidadCamasElementos.forEach(function (elemento) {
            let valor = parseInt(elemento.value, 10); // Convierte el valor a entero
            if (!isNaN(valor)) {
                valoresCantidadCamas.push(valor); // Agrega el valor al array si es un número válido
            }
        });

        // Calcula la suma total de las camas ingresadas
        let sumaTotal = 0;
        valoresCantidadCamas.forEach(function (valor) {
            sumaTotal += valor;
        });

        // Si la suma total de camas ingresadas coincide con la cantidad de camas en la BD
        if (sumaTotal === numCantCamas) {
            estadoInput['cantCamasTotales'] = true;
        } else {
            errorCantCamas = true;
        }
    }

    return errorCantCamas;
}

// Evento submit del formulario
formularioEdit.addEventListener('submit', (e) => {

    e.preventDefault(); // No dejar enviar el formulario hasta que sea válido

    // Llamamos a la función para validar las camas
    let errorCantCamas = validarCamas();

    // Si todos los campos son válidos, se envía el formulario
    if (estadoInput.numHabitacionEdit && estadoInput.observacionesEdit && inputCheck.length > 0 && estadoInput.cantCamasTotales) {
        formulario.submit();
    } else {
        // Si hay error en la cantidad de camas o no se seleccionó ningún checkbox
        if (errorCantCamas) {
            document.getElementById("msjErrorTipoCama2").style.display = "block";
        } else {
            document.getElementById("msjErrorTipoCama").style.display = "block";
        }
    }

});
