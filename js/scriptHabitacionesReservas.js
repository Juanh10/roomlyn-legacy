$(document).ready(function () {
    $('#onload').fadeOut(); //TODO Desaparece el elemento
    $('.cabeceraHab').show(); //TODO Muestra el elemento

    $('.btnAbrirDetalles').click(function(){
        let detalles = $(this).next('.inforDetalles');
        console.log(detalles);
        if (detalles.is(':visible')) {
            $('.flechaDetalles').removeClass('active');
            detalles.hide();
        } else {
            $('.flechaDetalles').addClass('active');
            detalles.show();
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
});