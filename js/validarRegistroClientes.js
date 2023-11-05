//*VER CONTRASEÑA
const contraseñaInput = document.querySelector("#contraseña");
const contraseña2Input = document.querySelector("#contraseña2");
const botonVer = document.querySelector(".verContraseña i");
const botonVer2 = document.querySelector(".verContraseña2 i");

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

botonVer2.onclick = (() => {

    if(contraseña2Input.type === "password"){
        contraseña2Input.type = "text";
        botonVer2.classList.add("bi-eye-slash");
        botonVer2.classList.remove("bi-eye");
    }else{
        contraseña2Input.type = "password";
        botonVer2.classList.remove("bi-eye-slash");
        botonVer2.classList.add("bi-eye");
    }

});


//* VALIDACIONES FORMULARIO DEL LOGIN 
const formulario = document.getElementById('form'); // acceder al formulario
const datosInput = document.querySelectorAll('#form input'); // seleccionar todos los inputs del formulario
const datosSelect = document.querySelectorAll('#form select'); // seleccionar todos los select del formulario
const select2Element = document.getElementById('nacionalidad');

const expresiones = {

    soloLetras: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
    contraseña: /^.{4,25}$/, // 4 a 25 digitos.
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    soloNumeros: /^\d{4,15}$/ // 4 a 15 numeros.

}

const estadoInput = {
    nombres: false,
    apellidos:false,
    documento: false,
    nCelular: false,
    email: false,
    tipoUsuario: false,
    contraseña: false,
}

const validarFormulario = (e) => {
    let nombreInput = e.target.name; // valor del nombre del input
    let valorInput = e.target; // valor del contenido del input

    // validamos los campos del input

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

        case 'celular':
            validarCampos(expresiones.soloNumeros, valorInput, 'nCelular', 'Rellene este campo con solo numeros'); // lo ponemos con parametros para ahorrar codigo
            break;

        case 'email':
            validarCampos(expresiones.correo, valorInput, 'email', 'Correo invalido'); // lo ponemos con parametros para ahorrar codigo
            break;

        case 'contraseña':
            validarCampos(expresiones.contraseña, valorInput, 'contraseña', 'La contraseña tiene que ser de 4 a 25 digitos'); // lo ponemos con parametros para ahorrar codigo
            validarContraseña();
            break;

        case 'contraseña2':
                validarContraseña();
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

//* VALIDAR CONTRASEÑA

const validarContraseña = () => {
    const contraseña1 = document.getElementById('contraseña');
    const contraseña2 = document.getElementById('contraseña2');

    if (contraseña1.value !== contraseña2.value) {
        document.getElementById("contraseña2").classList.add('validarInput'); // agregamos clase del input
        document.getElementById("contraseña2").nextElementSibling.classList.add('inputError'); // agregamos clase a la etiqueta hermana del input
        document.getElementById("contraseña2").nextElementSibling.innerText = "La contraseña no coinciden"; // ponemos texto a la etiqueta hermana del inpu
        estadoInput["contraseña"] = false;
    } else {
        document.getElementById("contraseña2").classList.remove('validarInput'); // quitamos clase al input
        document.getElementById("contraseña2").nextElementSibling.classList.remove('inputError'); // quitamos clase a la etiqueta hermana del input
        document.getElementById("contraseña2").nextElementSibling.innerText = ""; // dejamos el texto vacio de la etiqueta hermana del input
        estadoInput["contraseña"] = true;
    }
}

//* VALIDAR SELECT

const validarSelects = (input, idCampo, message) =>{
    let gValor = input.value;
    if(gValor === ""){
        document.getElementById(`${idCampo}`).classList.add('validarInput'); // agregamos clase del input
        document.getElementById(`${idCampo}`).nextElementSibling.classList.add('inputError'); // agregamos clase a la etiqueta hermana del input
        document.getElementById(`${idCampo}`).nextElementSibling.innerText = message; // ponemos texto a la etiqueta hermana del input
        estadoInput[idCampo] = false;
    }else{
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

//* Funcion para cuando se le de clic al boton de registrar
let estadoSelect = true;
form.addEventListener('submit', (e) => {
    e.preventDefault();

    const valorSeleccionado = select2Element.value;

    if (!valorSeleccionado) {
        estadoSelect = false;
    } else {
        estadoSelect = true;
    }

    if(estadoInput.nombres && estadoInput.apellidos && estadoInput.documento && estadoInput.nCelular && estadoInput.email && estadoInput.contraseña && estadoSelect){

        form.submit();  

    }else{
        document.querySelector(".formularioMensaje").classList.add("activoMensaje");
    }

});