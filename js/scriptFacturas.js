$(document).ready(function () {

    $('#totalFacturaEdit').click(function () {

        let totalText = $(this).next().text().replace(/[^\d]/g, '');

        $(this).next().hide();
        $('#totalFacturaEdit').hide();
        $('#nuevoValor').val(totalText).attr('type', 'number').focus().show();
        $('#guardarValor').show();
    });

    $('#guardarValor').off('click').on('click', function () {
        let nuevoValor = $('#nuevoValor').val();
        let reservaDias = $('#infoHabDias').attr('data-dias');
        let checkin = $('.fechaHospedaje').attr('data-checkin');
        let checkout = $('.fechaHospedaje').attr('data-checkout');
        let idHab = $('.facturaReserva').attr('data-idHab');
        let idTipoHab = $('.facturaReserva').attr('data-idTipoHab');

        let totalFactura = nuevoValor * reservaDias;

        $.ajax({
            url: 'formularioReserva.php',
            type: 'GET',
            data: {
                totalFactura: totalFactura,
                idHabitacion: idHab,
                idTipoHab: idTipoHab,
                checkin: checkin,
                checkout: checkout
            },
            success: function (response) {
                //console.log('ASH ME QUEDÓ GRANDE :(');
                $('.formularioReserva').html(response);
            },
            error: function () {
                alert('Hubo un error al guardar el valor.');
            }
        });

        // Ocultar el input y el botón de guardado y mostrar nuevamente el span totalFacturaValor
        $('#nuevoValor').attr('type', 'hidden');
        $('#totalFacturaValor').text(new Intl.NumberFormat('es-CO').format(nuevoValor)).show();
        $('#infoHabDiasValor').text(new Intl.NumberFormat('es-CO').format(totalFactura)).show();
        $('.precioTotal').text(new Intl.NumberFormat('es-CO').format(totalFactura) + ' COP');
        $('#totalFacturaFinal').text(new Intl.NumberFormat('es-CO').format(totalFactura) + ' COP');
        $('#totalFacturaEdit').show();
        $('#guardarValor').hide();
    });

});