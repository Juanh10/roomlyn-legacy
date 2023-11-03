$(document).ready(function () {
    $('#onload').fadeOut(); //TODO Desaparece el elemento
    $('.cabeceraHab').show(); //TODO Muestra el elemento

    //* EVENTO CLICK BUSCADOR PARA AGREGAR Y QUITAR CLASE AL DIV BUSCADOR Y EL DIV DEL LOGO

    $('.btnBuscar').click(function () {
        $('.buscador').toggleClass('activoBuscador');
        $('.logoPlahotHab').toggleClass('estadoLogo');
    });


    // Establecer desde la fecha actual el calendario de la fecha de entrada y salida

    let fechaActual = new Date().toISOString().split('T')[0];

    $('#fechaEntrada').attr('min', fechaActual);
    $('#fechaSalida').attr('min', fechaActual);

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



});