const contenedorNfcCliente = $('#contenidoHab');
const seleccion = contenedorNfcCliente.data('label');

$(document).ready(function () {

  // Mostrando contenido con AJAX
  $.ajax({
    url: 'filtroNfcContenido.php',
    type: 'GET',
    data: {
      seleccion: seleccion
    },
    success: function (response) {
      // Insertar el contenido en el div
      contenedorNfcCliente.html(response);
    },
    error: function (xhr) { // xhr: objeto para saber el codigo de estado http con status
      contenedorNfcCliente.html(`<p>Error al cargar el contenido ${xhr.status}</p>`);
    }
  });


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

  function cambiarEstado(idHabitacion, archivo, contenido) {
    fetch(`../vistasAdmin/cambiarEstadoRecepcion.php?id=${idHabitacion}&archivo=${archivo}`)
      .then(res => res.text())
      .then(datos => contenido.html(datos))
      .catch();
  }

});