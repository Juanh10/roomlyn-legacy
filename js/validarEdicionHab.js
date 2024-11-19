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

const inputNfc = $('#codNfc');
const modal = $('#modalEditNFC');
let intervaloFoco;
let temporizadorCaptura;
const retrasoCaptura = 500; // ms

// Funcion para mantener el foco del input
function mantenerFoco() {
    inputNfc.focus();
}

function alertaSweet(message, icon){
    Swal.fire({
        position: '',
        icon: icon,
        text: message,
        showConfirmButton: false,
        timer: 2000
    });
}

// Funcion para procesar el código NFC
function procesarCodigoNFC(codigo, idHab) {
    fetch(`../../procesos/registroHabitaciones/registroHabi/conActualizarHabitaciones.php?codigoNfc=${codigo}&idHab=${idHab}`)
        .then(res => res.json())
        .then(datos => {
           if(datos.status === 'success'){
            alertaSweet(datos.message, 'success')
           }else{
            alertaSweet(datos.message,'error')
           }
            clearInterval(intervaloFoco);
            inputNfc.blur();
            modal.modal('hide');
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Agregar el foco cuando el modal está abierto
modal.on('shown.bs.modal', function () {
    inputNfc.val(''); // Limpiar el input
    mantenerFoco();

    // Mantener el foco cada 100 ms
    intervaloFoco = setInterval(mantenerFoco, 100);
});

// Evento input para capturar el código del NFC
inputNfc.on('input', function () {
    clearTimeout(temporizadorCaptura);

    temporizadorCaptura = setTimeout(() => {
        const codigoNFC = $(this).val().trim();
        const idHab = $('#idHabitacionNFC').val().trim();

        // Si el código NFC tiene longitud mayor que 0, procesarlo y enviarlo
        if (codigoNFC.length > 0) {
            procesarCodigoNFC(codigoNFC, idHab);
        }
    }, retrasoCaptura);
});

// Limpiar intervalos y temporizadores cuando se cierra el modal
modal.on('hidden.bs.modal', function () {
    clearInterval(intervaloFoco);
    clearTimeout(temporizadorCaptura);
});

/* // Validar el input
function validarYEnviarFormulario(e) {
    const texto = inputCodNfc.value.trim();
    if (texto === '') {
        e.preventDefault();
        inputCodNfc.focus();
    }
}

// Agregar eventos
formeditLlaveroNFC.addEventListener('submit', validarYEnviarFormulario); */


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


formularioEdit.addEventListener('submit', (e) => {

    let inputCheck = document.querySelectorAll(".tiposDeCamasEdit input:checked"); // checkbox a los tipos de camas


    const cantidadCamasElementos = document.querySelectorAll(".cantidadCamasEdit");
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
        estadoInput[cantCamasTotales] = true;
    } else {
        errorCantCamas = true;
    }


    e.preventDefault(); // No dejar enviar el formulario

    if (estadoInput.numHabitacionEdit && estadoInput.observacionesEdit && inputCheck.length >= 1 && estadoInput.cantCamasTotales) {
        formulario.submit();
    } else {

        if (errorCantCamas) {
            document.getElementById("msjErrorTipoCama2").style.display = "block";
        } else {
            document.getElementById("msjErrorTipoCama").style.display = "block";
        }
    }

});