const expresiones = {
    soloLetrasNumeros: /^[a-zA-Z0-9áéíóúüñÑ ]+$/, // Letras numeros y espacios, pueden llevar acentos.
    soloNumeros: /^[0-9,.]+$/ //solo numeros
}

const estadoInput = {
    nombreTipo: false,
    cantidadCamas: false,
    cantidadPersonas: false,
    precioVentilador: false,
    precioAire: false,
    imagenes: false
}

const validarCampo = ((expresion, input, idCampo, message) => {

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

});



if (document.getElementById('formularioReg')) {

    //* validaciones del formulario de registro de tipos de habitaciones
    const formularioTipoHab = document.getElementById('formularioReg'); // acceder al formulario
    const formularioInput = document.querySelectorAll('#formularioReg input');

    const validarFormulario = ((e) => {
        let datoInput = e.target;

        let nombreinput = e.target.name; // acceder a los nombres de los inputs

        switch (nombreinput) {
            case 'nombreTipo':
                validarCampo(expresiones.soloLetrasNumeros, datoInput, 'nombreTipo', 'Llena este campo (no se permite caracteres especiales)');
                break;

            case 'cantidadCamas':
                validarCampo(expresiones.soloNumeros, datoInput, 'cantidadCamas', 'Llena este campo con solo numeros');
                break;

            case 'cantidadPersonas':
                validarCampo(expresiones.soloNumeros, datoInput, 'cantidadPersonas', 'Llena este campo con solo numeros');
                break;

            case 'precioVentilador':
                validarCampo(expresiones.soloNumeros, datoInput, 'precioVentilador', 'Llena este campo con solo numeros');
                break;

            case 'precioAire':
                validarCampo(expresiones.soloNumeros, datoInput, 'precioAire', 'Llena este campo con solo numeros');
                break;

            case 'imagenes[]':
                let arregloExt = ["jpeg", "jpg", "png", "bmp", "webp", "tiff", "svg"];
                validarinputFile(datoInput, 'imagenes', `Las únicas extensiones permitidas son ${arregloExt}`)
                break;

            default:
                break;
        }
    });


    const validarinputFile = ((input, idCampo, message) => { // validar las imagenes
        input.addEventListener('change', (e) => { // evento change para saber toda la informacion del input file
            let arregloFiles = [...e.target.files]; // convierto todos los files en un arreglo
            arregloFiles.forEach((file) => { // recorremos el arreglo
                let fileExt = file.name.split(".").pop().toLowerCase(); // para sacar la extension de la imagen (png,jpg,jepg, etc)
                let arregloExt = ["jpeg", "jpg", "png", "bmp", "webp", "tiff", "svg"];

                if (!arregloExt.includes(fileExt)) { // si en el arreglo no aparece esas extensiones
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

            });
        });
        input.addEventListener('blur', (input) => {
            let vacioInputFile = input.target.files.length;
            if (vacioInputFile === 0) {
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
        })
    });

    formularioInput.forEach((input) => {
        input.addEventListener('keyup', validarFormulario);
        input.addEventListener('blur', validarFormulario);
    });

    formularioTipoHab.addEventListener('submit', function (e) {

        e.preventDefault(); // no dejar enviar el formulario

        if (estadoInput.nombreTipo && estadoInput.cantidadCamas && estadoInput.cantidadPersonas && estadoInput.precioAire && estadoInput.precioVentilador && estadoInput.imagenes) {
            formularioTipoHab.submit();
        } else {
            document.querySelector(".formularioMensaje").classList.add("activoMensaje");
        }

    })

}else{

    const formularioTipoHabAct = document.getElementById('formActTipoCama'); // acceder al formulario
    const formularioInputAct = document.querySelectorAll('#formActTipoCama input');

    const validarFormularioAct = ((e) => {
        let datoInput = e.target;

        let nombreinput = e.target.name; // acceder a los nombres de los inputs

        switch (nombreinput) {
            case 'nombreTipo':
                validarCampo(expresiones.soloLetrasNumeros, datoInput, 'nombreTipo', 'Llena este campo (no se permite caracteres especiales)');
                break;

            case 'cantidadCamas':
                validarCampo(expresiones.soloNumeros, datoInput, 'cantidadCamas', 'Llena este campo con solo numeros');
                break;

            case 'cantidadPersonas':
                validarCampo(expresiones.soloNumeros, datoInput, 'cantidadPersonas', 'Llena este campo con solo numeros');
                break;

            case 'precioVentilador':
                validarCampo(expresiones.soloNumeros, datoInput, 'precioVentilador', 'Llena este campo con solo numeros');
                break;

            case 'precioAire':
                validarCampo(expresiones.soloNumeros, datoInput, 'precioAire', 'Llena este campo con solo numeros');
                break;
        }
    });

    formularioInputAct.forEach((input) => {
        input.addEventListener('keyup', validarFormularioAct);
        input.addEventListener('blur', validarFormularioAct);
        validarFormularioAct({ target: input });
    });

    //* validaciones de los input checkbox


    formularioTipoHabAct.addEventListener('submit', function (e) {

        e.preventDefault(); // no dejar enviar el formulario

        if (estadoInput.nombreTipo && estadoInput.cantidadCamas && estadoInput.cantidadPersonas && estadoInput.precioAire && estadoInput.precioVentilador) {
            formularioTipoHabAct.submit();
        } else {
            document.querySelector(".formularioMensaje").classList.add("activoMensaje");
        }

    })

}