const expresiones = {

    soloLetras: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
    usuario: /^[a-zA-Z0-9\_\-]{4,30}$/, // Letras, numeros, guion y guion_bajo
    contraseña: /^.{4,25}$/, // 4 a 25 digitos.
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    soloNumeros: /^\d{4,15}$/ // 4 a 15 numeros.

}

const estadoInput = {
    pNombre: false,
    pApellido: false,
    tDocumento: false,
    documento: false,
    nCelular: false,
    email: false,
    tipoUsuario: false,
    usuario: false,
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

//* VALIDAR CONTRASEÑA

const validarContraseña = () => {
    const contraseña1 = document.getElementById('contraseña');
    const contraseña2 = document.getElementById('contraseña2');

    if (contraseña1.value !== contraseña2.value) {
        document.getElementById("contraseña2").classList.add('inputError'); // agregamos clase del input
        document.getElementById("contraseña2").nextElementSibling.classList.add('error'); // agregamos clase a la etiqueta hermana del input
        document.getElementById("contraseña2").nextElementSibling.innerText = "La contraseña no coinciden"; // ponemos texto a la etiqueta hermana del inpu
        estadoInput["contraseña"] = false;
    } else {
        document.getElementById("contraseña2").classList.remove('inputError'); // quitamos clase al input
        document.getElementById("contraseña2").nextElementSibling.classList.remove('error'); // quitamos clase a la etiqueta hermana del input
        document.getElementById("contraseña2").nextElementSibling.innerText = ""; // dejamos el texto vacio de la etiqueta hermana del input
        estadoInput["contraseña"] = true;
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
    const contraseñaInput = document.querySelector("#contraseña");
    const contraseña2Input = document.querySelector("#contraseña2");
    const botonVer = document.querySelector(".verContraseña i");
    const botonVer2 = document.querySelector(".verContraseña2 i");

    botonVer.onclick = (() => {

        if (contraseñaInput.type === "password") {
            contraseñaInput.type = "text";
            botonVer.classList.add("bi-eye-slash");
            botonVer.classList.remove("bi-eye");
        } else {
            contraseñaInput.type = "password";
            botonVer.classList.remove("bi-eye-slash");
            botonVer.classList.add("bi-eye");
        }


    });

    botonVer2.onclick = (() => {

        if (contraseña2Input.type === "password") {
            contraseña2Input.type = "text";
            botonVer2.classList.add("bi-eye-slash");
            botonVer2.classList.remove("bi-eye");
        } else {
            contraseña2Input.type = "password";
            botonVer2.classList.remove("bi-eye-slash");
            botonVer2.classList.add("bi-eye");
        }

    });


    //* VALIDACIONES FORMULARIO DEL LOGIN 
    const formulario = document.getElementById('form'); // acceder al formulario
    const datosInput = document.querySelectorAll('#form input'); // seleccionar todos los inputs del formulario
    const datosSelect = document.querySelectorAll('#form select'); // seleccionar todos los select del formulario

    const validarFormulario = (e) => {
        let nombreInput = e.target.name; // valor del nombre del input
        let valorInput = e.target; // valor del contenido del input

        // validamos los campos del input

        switch (nombreInput) {
            case 'primerNombre':
                validarCampos(expresiones.soloLetras, valorInput, 'pNombre', 'Rellene este campo con solo letras'); // lo ponemos con parametros para ahorrar codigo
                break;

            case 'primerApellido':
                validarCampos(expresiones.soloLetras, valorInput, 'pApellido', 'Rellene este campo con solo letras'); // lo ponemos con parametros para ahorrar codigo
                break;

            case 'tipoDocumento':
                validarSelects(valorInput, 'tDocumento', 'Escoja una opcion');
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

            case 'usuario':
                validarCampos(expresiones.usuario, valorInput, 'usuario', 'El usuario tiene que ser de 4 a 30 digitos'); // lo ponemos con parametros para ahorrar codigo
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
    formulario.addEventListener('submit', (e) => {
        e.preventDefault();

        if (estadoInput.pNombre && estadoInput.pApellido && estadoInput.documento && estadoInput.tDocumento && estadoInput.documento && estadoInput.nCelular && estadoInput.email && estadoInput.usuario && estadoInput.contraseña) {

            formulario.submit();

        } else {
            document.querySelector(".formularioMensaje").classList.add("activoMensaje");
        }

    });

} else {

    const modal = new bootstrap.Modal(document.getElementById('modalActualizarUsuario'));

    modal._element.addEventListener('shown.bs.modal', function () {
        const formularioAct = document.getElementById('formularioAct'); // acceder al formulario
        const datosInputAct = document.querySelectorAll('#formularioAct input'); // seleccionar todos los inputs del formulario
        const datosSelectAct = document.querySelectorAll('#formularioAct select'); // seleccionar todos los select del formulario
    
        const validarFormularioAct = (e) => {
            let nombreInput = e.target.name; // valor del nombre del input
            let valorInput = e.target; // valor del contenido del input
    
            // validamos los campos del input
    
            switch (nombreInput) {
                case 'primerNombreUsuario':
                validarCampos(expresiones.soloLetras, valorInput, 'pNombre', 'Rellene este campo con solo letras');
                break;
    
            case 'primerApellidoUsuario':
                validarCampos(expresiones.soloLetras, valorInput, 'pApellido', 'Rellene este campo con solo letras');
                break;
    
            case 'tipoDocumento':
                validarSelects(valorInput, 'tDocumento', 'Escoja una opcion');
                break;
    
            case 'documentoUsuario':
                validarCampos(expresiones.soloNumeros, valorInput, 'documento', 'Rellene este campo con solo numeros');
                break;
    
            case 'telefonoUsuario':
                validarCampos(expresiones.soloNumeros, valorInput, 'nCelular', 'Rellene este campo con solo numeros');
                break;
    
            case 'emailUsuario':
                validarCampos(expresiones.correo, valorInput, 'email', 'Correo invalido');
                break;
    
            case 'usuario':
                validarCampos(expresiones.usuario, valorInput, 'usuario', 'El usuario tiene que ser de 4 a 30 dígitos');
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
    
        //* Funcion para cuando se le de clic al boton de registrar
        formularioAct.addEventListener('submit', (e) => {
            e.preventDefault();
    
            if (estadoInput.pNombre && estadoInput.pApellido && estadoInput.documento && estadoInput.nCelular && estadoInput.email && estadoInput.usuario) {
    
                formularioAct.submit();
    
            } else {
                document.querySelector(".formularioMensaje").classList.add("activoMensaje");
            }
    
        });
    });

}