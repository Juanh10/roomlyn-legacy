$(document).ready(function () {
    $('#onload').fadeOut(); //TODO Desaparece el elemento
    $('.cabeceraHab').show(); //TODO Muestra el elemento

    //* EVENTO CLICK BUSCADOR PARA AGREGAR Y QUITAR CLASE AL DIV BUSCADOR Y EL DIV DEL LOGO

    $('.btnBuscar').click(function () {
        $('.buscador').toggleClass('activoBuscador');
        $('.logoPlahotHab').toggleClass('estadoLogo');
    });

    //* ALERTA DE CONFIRMACION DEL FORMULARIO

    $('.formReservas').submit(function (e) {
        e.preventDefault(); // sirve para parar lo que esta haciendo el navegador
        Swal.fire({
          title: '¿Estas seguro de realizar la reserva?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Aceptar'
        }).then((result) => {
          if (result.isConfirmed) {
            this.submit(); // sirve para enivar los datos del formulario
          }
        });
      });


    //* Establecer desde la fecha actual el calendario de la fecha de entrada y salida

    // Obtener la fecha actual en UTC
    let fechaActualUTC = new Date();

    // Seleccionar los campos de fecha de llegada y salida
    let fechaLlegada = $('#fechaEntrada');
    let fechaSalida = $('#fechaSalida');

    // Ajustar el desplazamiento horario a UTC-5 (Colombia)
    fechaActualUTC.setUTCHours(fechaActualUTC.getUTCHours() - 5);

    // Formatear la fecha en el formato deseado (YYYY-MM-DD)
    let fechaActualColombia = fechaActualUTC.toISOString().split('T')[0];

    // Establecer la fecha en los elementos HTML
    fechaLlegada.attr('min', fechaActualColombia);
    fechaSalida.attr('min', fechaActualColombia);

    // Agregar un evento change al campo de fecha de llegada para validar los campos
    fechaLlegada.change(function () {
        let fechaLlegada2 = new Date(fechaLlegada.val());
        let fechaSalida2 = new Date(fechaSalida.val());

        // Verificar si la fecha de llegada es mayor o igual a la fecha de salida
        if (fechaLlegada2 >= fechaSalida2) {
            fechaSalida2.setDate(fechaLlegada2.getDate() + 1);
            fechaSalida.val(fechaSalida2.toISOString().split('T')[0]);
        }
    })


});




// BUSCADOR EN TIEMPO REAL

// Funcion para quitar las tildes
function removeDiacritics(text) {
    return text.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

$(document).ready(function () {
    $('#buscador').on('input', function () {
        const inputBuscador = removeDiacritics($(this).val().toLowerCase()); // obtener el valor del input
        let resultadoBusqueda = false;

        $('.cardHabitaciones').each(function () {
            const cardContenido = removeDiacritics($(this).text().toLowerCase()); // obtener el valor de los card de las habitaciones
            if (cardContenido.includes(inputBuscador)) { // condicion para saber si encontró alguna coincidencia
                $(this).show();
                resultadoBusqueda = true;
            } else {
                $(this).hide();
            }
        });

        // Mostrar el mensaje si no se encuentran resultados
        if (!resultadoBusqueda) {
            $('.hab-no-disponibles').show();
        } else {
            $('.hab-no-disponibles').hide();
        }
    });

    // FECHAS CHECKIN Y CHECKOUT 

    function recibirFechasRango() {
        let fechaSalida = $("#fechaSalida").val(); // obtenemos la fecha
        let fechaEntrada = $("#fechaEntrada").val(); // obtenemos la fecha
        let tipoHab = $("#tipoHab").val();
        let habitacion = $("#habitacion").val();

        let rangoFechas = fechaEntrada + " - " + fechaSalida;

        // Verificar si ambos campos tienen valores
        if (fechaSalida && fechaEntrada) {
            // Realizar la petición AJAX
            realizarPeticion(rangoFechas, tipoHab, habitacion);
        }
    }

    recibirFechasRango();

    // Escuchar el evento change en ambos campos
    $("#fechaSalida, #fechaEntrada").on("change", function () {
        let fechaSalida = $("#fechaSalida").val(); // obtenemos la fecha
        let fechaEntrada = $("#fechaEntrada").val(); // obtenemos la fecha
        let tipoHab = $("#tipoHab").val();
        let habitacion = $("#habitacion").val();

        let rangoFechas = fechaEntrada + " - " + fechaSalida;

        // Verificar si ambos campos tienen valores
        if (fechaSalida && fechaEntrada) {
            // Realizar la petición AJAX
            realizarPeticion(rangoFechas, tipoHab, habitacion);
        }

    });

    let factura = $('.col-factura');

    // Función para realizar la petición AJAX
    function realizarPeticion(rangoFechas, tipoHab, habitacion) {
        fetch(`reservas/facturaReserva.php?fechasRango=${rangoFechas}&tipoHab=${tipoHab}&habitacion=${habitacion}`)
            .then(res => res.text())
            .then(datos => factura.html(datos))
            .catch();
    }


    // INICIALIZAR LA LIBRERIA DE SELECT2

    $('#nacionalidad').select2();
    $('#departamento').select2();
    $('#ciudad').select2();

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




});