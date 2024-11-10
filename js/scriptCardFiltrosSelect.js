$(document).ready(function () {
    function cambiarEstado(idHabitacion, archivo, contenido) {
        fetch(`../vistasAdmin/cambiarEstadoRecepcion.php?id=${idHabitacion}&archivo=${archivo}`)
            .then(res => res.text())
            .then(datos => contenido.html(datos))
            .catch();
    }

    $('.btnDisponible').click(function () {
        let idHabitacion = $(this).attr('id');
        let fechaRango = $(this).find('span:first').attr('id');
        let tipoHab = $(this).find('span:last').attr('id');
        let archivo = "";
        $('#cambiarEstadoDispo').click(function () {
            archivo = "recepcion";
            let content = $('#contentCamEstadoDis');
            cambiarEstado(idHabitacion, archivo, content);
        });

        $('#btnReservarRecepcion').click(function () {
            archivo = "recepcion";
            window.location.href = `reservarRecepcion.php?idHabitacion=${idHabitacion}&idTipoHab=${tipoHab}&archivo=${archivo}&fechasRango=${fechaRango}`;
        });

    });

    $('.btnCambiarEstado').click(function () {
        let idHabitacion = $(this).attr('id');
        let archivo = "recepcion";
        let content = $('#contentCamEstadoDi');
        cambiarEstado(idHabitacion, archivo, content);
    });

    $('.btnPendiente').click(function () {
        let idHabitacion = $(this).attr('id');
        let contenido = $('#inforClientePendiente');

        fetch(`../vistasAdmin/inforClientePendiente.php?id=${idHabitacion}`)
            .then(res => res.text())
            .then(datos => contenido.html(datos))
            .catch();

    });

    $('.btnReservada').click(function () {
        let idHabitacion = $(this).attr('id');
        let contenido = $('#inforClienteConfir');

        fetch(`../vistasAdmin/inforClientesConfir.php?id=${idHabitacion}`)
            .then(res => res.text())
            .then(datos => contenido.html(datos))
            .catch();
    });

    $('.btnOcupado').click(function () {
        let idHabitacion = $(this).attr('id');
        let contenido = $('#inforClienteOcupado');

        fetch(`../vistasAdmin/inforClienteOcupado.php?id=${idHabitacion}`)
            .then(res => res.text())
            .then(datos => contenido.html(datos))
            .catch();
    });
})