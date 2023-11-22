const expresiones = {
    soloLetras: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
    contraseña: /^.{4,25}$/, // 4 a 25 digitos.
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    soloNumeros: /^\d{4,15}$/ // 4 a 15 numeros.
}


const estadoInput = {
    nombres: false,
    apellidos: false,
    documento: false,
    nCelular: false,
    email: false,
    sexo: false,
    tipoUsuario: false,
    contraseña: false,
}

//* funcion para las validaciones de los campos

const validarCampos = (expresion, input, idCampo, message) => {
    if (expresion.test(input.value)) { // validamos si cumple con las expresiones regulares
        document.getElementById(`${idCampo}`).classList.remove('inputError'); // quitamos clase al input
        document.getElementById(`${idCampo}`).nextElementSibling.classList.remove('error'); // quitamos clase a la etiqueta hermana del input
        document.getElementById(`${idCampo}`).nextElementSibling.innerText = ""; // dejamos el texto vacio de la etiqueta hermana del input
        estadoInput[idCampo] = true;
    } else {
        document.getElementById(`${idCampo}`).classList.add('inputError'); // agregamos clase del input
        document.getElementById(`${idCampo}`).nextElementSibling.classList.add('error'); // agregamos clase a la etiqueta hermana del input
        document.getElementById(`${idCampo}`).nextElementSibling.innerText = message; // ponemos texto a la etiqueta hermana del input
        estadoInput[idCampo] = false;
    }
}


//* VALIDAR SELECT

const validarSelects = (input, idCampo, message) => {
    let gValor = input.value;
    if (gValor === "") {
        document.getElementById(`${idCampo}`).classList.add('inputError'); // agregamos clase del input
        document.getElementById(`${idCampo}`).nextElementSibling.classList.add('error'); // agregamos clase a la etiqueta hermana del input
        document.getElementById(`${idCampo}`).nextElementSibling.innerText = message; // ponemos texto a la etiqueta hermana del input
        estadoInput[idCampo] = false;
    } else {
        document.getElementById(`${idCampo}`).classList.remove('inputError'); // quitamos clase al input
        document.getElementById(`${idCampo}`).nextElementSibling.classList.remove('error'); // quitamos clase a la etiqueta hermana del input
        document.getElementById(`${idCampo}`).nextElementSibling.innerText = ""; // dejamos el texto vacio de la etiqueta hermana del input
        estadoInput[idCampo] = true;
    }
}

if (document.getElementById('form')) {

    //*VER CONTRASEÑA
    const contrasenaInput = document.querySelector("#contrasena");
    const contrasena2Input = document.querySelector("#contrasena2");
    const botonVer = document.querySelector(".verContraseña i");
    const botonVer2 = document.querySelector(".verContraseña2 i");

    botonVer.onclick = (() => {

        if (contrasenaInput.type === "password") {
            contrasenaInput.type = "text";
            botonVer.classList.add("bi-eye-slash");
            botonVer.classList.remove("bi-eye");
        } else {
            contrasenaInput.type = "password";
            botonVer.classList.remove("bi-eye-slash");
            botonVer.classList.add("bi-eye");
        }


    });

    botonVer2.onclick = (() => {

        if (contrasena2Input.type === "password") {
            contrasena2Input.type = "text";
            botonVer2.classList.add("bi-eye-slash");
            botonVer2.classList.remove("bi-eye");
        } else {
            contrasena2Input.type = "password";
            botonVer2.classList.remove("bi-eye-slash");
            botonVer2.classList.add("bi-eye");
        }

    });


    const formulario = document.getElementById('form'); // acceder al formulario
    const datosInput = document.querySelectorAll('#form input'); // seleccionar todos los inputs del formulario
    const select2Element = document.getElementById('nacionalidad');
    const datosSelect = document.querySelectorAll('#form select'); // seleccionar todos los select del formulario

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

            case 'sexo':
                validarSelects(valorInput, 'sexo', 'Debe de escoger una opción');
                break;

            case 'contrasena':
                validarCampos(expresiones.contraseña, valorInput, 'contrasena', 'La contraseña tiene que ser de 4 a 25 digitos'); // lo ponemos con parametros para ahorrar codigo
                validarContraseña();
                break;

            case 'contrasena2':
                validarContraseña();
                break;

            default:
                break;
        }
    }


    //* VALIDAR CONTRASEÑA

    const validarContraseña = () => {
        const contraseña1 = document.getElementById('contrasena');
        const contraseña2 = document.getElementById('contrasena2');

        if (contraseña1.value !== contraseña2.value) {
            document.getElementById("contrasena2").classList.add('inputError'); // agregamos clase del input
            document.getElementById("contrasena2").nextElementSibling.classList.add('error'); // agregamos clase a la etiqueta hermana del input
            document.getElementById("contrasena2").nextElementSibling.innerText = "La contraseña no coinciden"; // ponemos texto a la etiqueta hermana del inpu
            estadoInput["contraseña"] = false;
        } else {
            document.getElementById("contrasena2").classList.remove('inputError'); // quitamos clase al input
            document.getElementById("contrasena2").nextElementSibling.classList.remove('error'); // quitamos clase a la etiqueta hermana del input
            document.getElementById("contrasena2").nextElementSibling.innerText = ""; // dejamos el texto vacio de la etiqueta hermana del input
            estadoInput["contraseña"] = true;
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
    });


    //* Funcion para cuando se le de clic al boton de registrar
    let estadoSelect = true;
    formulario.addEventListener('submit', (e) => {
        e.preventDefault();

        const valorSeleccionado = select2Element.value;

        if (!valorSeleccionado) {
            estadoSelect = false;
        } else {
            estadoSelect = true;
        }

        if (estadoInput.nombres && estadoInput.apellidos && estadoInput.documento && estadoInput.nCelular && estadoInput.email && estadoInput.contraseña && estadoSelect) {

            formulario.submit();

        } else {
            document.querySelector(".formularioMensaje").classList.add("activoMensaje");
        }

    });

} else {
    //* VALIDACIONES FORMULARIO DEL LOGIN 
    const formularioAct = document.getElementById('formAct'); // acceder al formulario
    const datosInputAct = document.querySelectorAll('#formAct input'); // seleccionar todos los inputs del formulario
    const datosSelectAct = document.querySelectorAll('#formAct select'); // seleccionar todos los select del formulario

    const validarFormularioAct = (e) => {
        let nombreInput = e.target.name;
        let valorInput = e.target;

        switch (nombreInput) {

            case 'nombres':
                validarCampos(expresiones.soloLetras, valorInput, 'nombres', 'Rellene este campo con solo letras');
                break;

            case 'apellidos':
                validarCampos(expresiones.soloLetras, valorInput, 'apellidos', 'Rellene este campo con solo letras');
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

            case 'sexo':
                validarSelects(valorInput, 'sexo', 'Debe de escoger una opción');
                break;

        }

    }


    //* ciclo donde recorre todos los inputs
    datosInputAct.forEach((input) => {
        input.addEventListener('input', validarFormularioAct);
        input.addEventListener('blur', validarFormularioAct);
        validarFormularioAct({ target: input });
    });

    //* ciclo donde reocorre todos los select

    datosSelectAct.forEach((select) => {
        select.addEventListener('blur', validarFormularioAct);
    });

    formularioAct.addEventListener('submit', (e) => {
        e.preventDefault();

        if (estadoInput.nombres && estadoInput.apellidos && estadoInput.documento && estadoInput.nCelular && estadoInput.email) {

            formularioAct.submit();

        } else {
            document.querySelector(".formularioMensaje").classList.add("activoMensaje");
        }

    });

}