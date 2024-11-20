$(document).ready(function () {
    $('.btnInforCli').click(function () {
        let idCLiente = $(this).attr('id');
        let contenido = $('#contenidoInforCliente');

        fetch(`../../vistas/vistasAdmin/inforCLienteReserva.php?id=${idCLiente}`)
            .then(res => res.text())
            .then(datos => contenido.html(datos))
            .catch();
    });

    // INICIALIZAR LA LIBRERIA DE SELECT2

    function initSelect2(id, modal) {
        $(id).select2({
            dropdownParent: $(modal) // Cambia esto por el ID de tu modal
        });
    }

    initSelect2('#nacionalidad', '#modalRegReserva')
    initSelect2('#departamento', '#modalRegReserva')
    initSelect2('#ciudad', '#modalRegReserva')

    // FUNCION PARA RECARGAR LA LISTA DE DEPARTAMENTOS Y CIUDADES POR MEDIO DE AJAX O FETCH
    function listaOrigenDepartamento() {
        let valorNacionalidad = $('#nacionalidad').val();
        let divDepartamento = $('#departamento');
        let divCiudad = $('#ciudad');

        // Realizar una consulta fetch para mostrar los departamentos
        fetch(`reservas/selectOrigen.php?valorNa=${valorNacionalidad}`)
            .then(res => res.text())
            .then(datos => {
                divDepartamento.html(datos);

                // Si el valor de nacionalidad no es igual a 43, que cargue la opcion "No requerido"
                if (valorNacionalidad != 43) {
                    fetch(`reservas/selectOrigenCiudad.php?valorDe=0`)
                        .then(resCiudad => resCiudad.text())
                        .then(datosCiudad => divCiudad.html(datosCiudad))
                        .catch();
                }
            })
            .catch();
    }

    listaOrigenDepartamento(); // Ejecutar la funcion

    $('#nacionalidad').change(function () { // evento change para saber cuando hay un cambio en el select
        listaOrigenDepartamento();
    });

    // Funcion para mostrar la lista de las ciudades segun el departamento esto lo hacemos por medio de FETCH

    function listaOrigenCiudad() {
        let valorDepartamento = $('#departamento').val();
        let divCiudad = $('#ciudad');

        // Realiza una única llamada a la función fetch para cargar las ciudades
        fetch(`reservas/selectOrigenCiudad.php?valorDe=${valorDepartamento}`) // realizar consulta fetch
            .then(res => res.text())
            .then(datos => divCiudad.html(datos))
            .catch();
    }

    listaOrigenCiudad(); // ejecutar la funcion

    $('#departamento').change(function () { // evento change para saber cuando hay un cambio en el select
        listaOrigenCiudad();
    });


    // ENVIAR LOS DATOS DEL FORMULARIO AL SERVIDOR CON AJAX

    function alertaSweet(message, icon, boton, tiempo) {
        Swal.fire({
            position: '',
            icon: icon,
            text: message,
            showConfirmButton: boton,
            timer: tiempo
        });
    }

    const numHabitacion = $('#habitacion');
    let verNumHab;
    let idTipoHab;

    numHabitacion.on("change", function () {
        verNumHab = $(this).val();
        if (verNumHab !== '') {
            $.ajax({
                url: `../../procesos/registroReservas/conObtenerTipoHab.php?numHab=${verNumHab}`,
                method: 'get',
                dataType: 'json',
                success: function (respuesta) {
                    if (respuesta.status === 'success') {
                        idTipoHab = respuesta.message;
                    }
                },
                error: function (error) {
                    if (error.status === 'error') {
                        alertaSweet(error.message, 'error', false, 1000);
                    }
                }
            });
        }
    });


    const totalReserva = $("#totalReserva");
    let montoReserva;

    totalReserva.on('blur', function () {
        let contTotal = $(this).val();
        if (contTotal !== '') {
            montoReserva = contTotal;
        }
    });


    $("#formHistorialReserva").submit(function (e) {
        e.preventDefault(); // Prevenir el envío tradicional del formulario
        const nombres = $('#nombres').val();
        const apellidos = $('#apellidos').val();
        const fechaEntrada = $("#fechaEntradaRes").val();
        const fechaSalida = $("#fechaSalidaRes").val();
        const documento = $('#documento').val();
        const telefono = $('#telefono').val();
        const email = $("#email").val();
        const numTotalReserva = totalReserva.val();
        const sexo = $('#sexo').val();
        const nacionalidad = $('#nacionalidad').val();
        const departamento = $('#departamento').val();
        const ciudad = $('#ciudad').val();
        const estadoRes = 4;

        // Expresiones para validar los datos
        const validNumeroRango = /^\d{4,15}$/; // 4 a 15 numeros.
        const validarSoloNumeros = /^\d+$/; // expresion regular de solo numeros
        const validarEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // expresion regular para correos


        // Variables para control de errores
        let esValido = true;
        let mensajeError = "Por favor corrija los siguientes errores:\n";

        // Validar campos requeridos
        $("#formHistorialReserva [required]").each(function () {
            if ($(this).val() === "") {
                esValido = false;
                mensajeError += `- El campo "${$(this).attr("id")}" es obligatorio.\n`;
            }
        });

        // Validar que las fechas tengan sentido
        if (fechaEntrada >= fechaSalida) {
            esValido = false;
            mensajeError += "- La fecha de salida debe ser posterior a la fecha de entrada.\n";
        }

        if (!validNumeroRango.test(documento)) {
            esValido = false;
            mensajeError += "- El documento no es válido.\n";
        }

        if (!validNumeroRango.test(telefono)) {
            esValido = false;
            mensajeError += "- El teléfono no es válido.\n";
        }

        // Validar correo electrónico
        if (!validarEmail.test(email)) {
            esValido = false;
            mensajeError += "- El correo electrónico no es válido.\n";
        }

        let nTotalReserva = parseFloat(numTotalReserva);

        // Validar que el monto de reserva sea un número positivo
        if (!validarSoloNumeros.test(numTotalReserva) || nTotalReserva <= 0) {
            esValido = false;
            mensajeError += "- El total de la reserva debe ser un número positivo.\n";
        }

        // Mostrar errores o proceder con el envío
        if (!esValido) {
            alertaSweet(mensajeError, 'error', true, 0)
            return;
        } else {
            $.ajax({
                url: '../../procesos/registroReservas/conRegistroReservasHistorial.php',
                method: 'POST',
                data: {
                    nombres: nombres,
                    apellidos: apellidos,
                    checkIn: fechaEntrada,
                    checkOut: fechaSalida,
                    documento: documento,
                    telefono: telefono,
                    email: email,
                    sexo: sexo,
                    nacionalidad: nacionalidad,
                    departamento: departamento,
                    ciudad: ciudad,
                    tipoHab: idTipoHab,
                    habitacion: verNumHab,
                    totalFactura: numTotalReserva,
                    montoReserva: montoReserva,
                    estadoRes: estadoRes
                },
                dataType: 'json',
                success: function (respuesta) {
                    if (respuesta.status === 'success') {
                        Swal.fire({
                            position: '',
                            icon: 'success',
                            title: 'Se registró con éxito',
                            showConfirmButton: true,
                            timer: 0
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            })
        }

    });

})