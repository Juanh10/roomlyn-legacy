$(document).ready(function () {
    $('.btnAbrirDetalles').click(function () {
        let detalles = $(this).next('.inforDetalles');
        if (detalles.is(':visible')) {
            $('.flechaDetalles').addClass('active');
            detalles.hide();
        } else {
            $('.flechaDetalles').removeClass('active');

            detalles.show();
        }
    });

    $('#totalFacturaEdit').click(function() {
        
        let totalText = $(this).next().text().replace(/[^\d]/g, '');
    
        $(this).next().hide();
        $('#totalFacturaEdit').hide();
        $('#nuevoValor').val(totalText).attr('type', 'number').focus().show();
        $('#guardarValor').show();
    });

    $('#guardarValor').click(function() {
        let nuevoValor = $('#nuevoValor').val();
        let reservaDias = $('#infoHabDias').attr('data-dias');

        let totalFactura = nuevoValor * reservaDias;
        

        $.ajax({
            url: 'reservarRecepcion.php', 
            type: 'POST',
            data: { totalFactura: totalFactura },
            success: function() {
                console.log('Perfecto');
            },
            error: function() {
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