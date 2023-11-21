//* VALIDACIONES FORMULARIO DEL LOGIN 
const formulario = document.getElementById('form'); // acceder al formulario
const datosInput = document.querySelectorAll('#form input'); // seleccionar todos los inputs del formulario
const datosSelect = document.querySelectorAll('#form select'); // seleccionar todos los select del formulario
const select2Element = document.getElementById('nacionalidad');

const expresiones = {

    soloLetras: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    soloNumeros: /^\d{4,15}$/ // 4 a 15 numeros.

}

const estadoInput = {
    nombres: false,
    apellidos: false,
    documento: false,
    telefono: false,
    sexo: false,
    email: false
}

const validarFormulario = (e) => {
    let nombreInput = e.target.name; // valor del nombre del input
    let valorInput = e.target; // valor del contenido del input

    switch (nombreInput) {
        case 'nombres':
            validarCampos(expresiones.soloLetras, valorInput, 'nombres', 'Rellene este campo con solo letras'); // lo ponemos con parametros para ahorrar codigo
            break;

        case 'apellidos':
            validarCampos(expresiones.soloLetras, valorInput, 'apellidos', 'Rellene este campo con solo letras'); // lo ponemos con parametros para ahorrar codigo
            break;

        case 'documento':
            validarCampos(expresiones.soloNumeros, valorInput, 'documento', 'Rellene este campo con solo numeros'); // lo ponemos con parametros para ahorrar codigo
            break;

        case 'sexo':
            validarSelects(valorInput, 'sexo', 'Escoja una opcion');
            break;

        case 'telefono':
            validarCampos(expresiones.soloNumeros, valorInput, 'telefono', 'Rellene este campo con solo numeros'); // lo ponemos con parametros para ahorrar codigo
            break;

        case 'email':
            validarCampos(expresiones.correo, valorInput, 'email', 'Correo invalido'); // lo ponemos con parametros para ahorrar codigo
            break;

        default:
            break;
    }
}


//* funcion para las validaciones de los campos

const validarCampos = (expresion, input, idCampo, message) => {
    if (expresion.test(input.value)) { // validamos si cumple con las expresiones regulares
        document.getElementById(`${idCampo}`).classList.remove('validarInput'); // quitamos clase al input
        document.getElementById(`${idCampo}`).nextElementSibling.classList.remove('inputError'); // quitamos clase a la etiqueta hermana del input
        document.getElementById(`${idCampo}`).nextElementSibling.innerText = ""; // dejamos el texto vacio de la etiqueta hermana del input
        estadoInput[idCampo] = true;
    } else {
        document.getElementById(`${idCampo}`).classList.add('validarInput'); // agregamos clase del input
        document.getElementById(`${idCampo}`).nextElementSibling.classList.add('inputError'); // agregamos clase a la etiqueta hermana del input
        document.getElementById(`${idCampo}`).nextElementSibling.innerText = message; // ponemos texto a la etiqueta hermana del input
        estadoInput[idCampo] = false;
    }
}

//* VALIDAR SELECT

const validarSelects = (input, idCampo, message) => {
    let gValor = input.value;
    if (gValor === "") {
        document.getElementById(`${idCampo}`).classList.add('validarInput'); // agregamos clase del input
        document.getElementById(`${idCampo}`).nextElementSibling.classList.add('inputError'); // agregamos clase a la etiqueta hermana del input
        document.getElementById(`${idCampo}`).nextElementSibling.innerText = message; // ponemos texto a la etiqueta hermana del input
        estadoInput[idCampo] = false;
    } else {
        document.getElementById(`${idCampo}`).classList.remove('validarInput'); // quitamos clase al input
        document.getElementById(`${idCampo}`).nextElementSibling.classList.remove('inputError'); // quitamos clase a la etiqueta hermana del input
        document.getElementById(`${idCampo}`).nextElementSibling.innerText = ""; // dejamos el texto vacio de la etiqueta hermana del input
        estadoInput[idCampo] = true;
    }
}

//* ciclo donde recorre todos los inputs
datosInput.forEach((input) => {
    input.addEventListener('input', validarFormulario);
    input.addEventListener('blur', validarFormulario);
});

//* ciclo donde reocorre todos los select

datosSelect.forEach((select) => {
    select.addEventListener('blur', validarFormulario);
})

let estadoSelect = true;
//* Funcion para cuando se le de clic al boton de registrar
formulario.addEventListener('submit', (e) => {
    e.preventDefault();

    const valorSeleccionado = select2Element.value;

    if (!valorSeleccionado) {
        estadoSelect = false;
    } else {
        estadoSelect = true;
    }

    if (estadoInput.nombres && estadoInput.apellidos && estadoInput.documento && estadoInput.sexo && estadoInput.email && estadoInput.telefono && estadoSelect) {
        $('#btnResClnNoReg').click(function () {
            Swal.fire({
                title: '¿Estás seguro de realizar la reserva?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit();
                }
            });
        });
    } else {
        document.querySelector(".formularioMensaje").classList.add("activoMensaje");
    }

});