//* Saber cuando ya se cargo correctamente el HTML

$(document).ready(function () {
  $('#onload').fadeOut(); //TODO Desaparece el elemento
  $('.cabeceraHab').show(); //TODO Muestra el elemento
  $('.btnWha').show();
  $('.flexslider').show();
  $('.filtros-habitaciones').show();
});

$(document).ready(function () {

  //* EVENTO CLICK BUSCADOR PARA AGREGAR Y QUITAR CLASE AL DIV BUSCADOR Y EL DIV DEL LOGO

  $('.btnBuscar').click(function () {
    $('.buscador').toggleClass('activoBuscador');
    $('.logoPlahotHab').toggleClass('estadoLogo');
  });

  //* LIBRERIA QUE AYUDA A QUE LA GALERIA DE IMAGENES TENGA EL EFECTO LIGHTOBX

  lightbox.option({
    'resizeDuration': 300,
    'wrapAround': true,
    'fitImagesInViewport': true,
    'imageFadeDuration': 200,
    'showImageNumberLabel': true,
    'albumLabel': "Imagen %1 de %2",
    'disableScrolling': true,
  });

  //* LIBRERIA PARA CONTROLAR LAS ANIMACIONES

  const sr = ScrollReveal();

  const animacion = (clase, origen, duracion, delay, distacia, ease) => {
    sr.reveal(clase, {
      origin: origen,
      duration: duracion,
      delay: delay,
      distance: distacia,
      easing: ease
    });
  }

  animacion('.cardHab', 'bottom', 1000, 200, '30px', 'ease-in-out');



  // RANGO DE FECHAS

  $(function () {
    let inputFechas = $('input[name="fechasRango"]');
    $(inputFechas).daterangepicker({
      locale: {
        format: 'YYYY/M/DD',
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
          "do",
          "Lu",
          "Ma",
          "Mi",
          "Ju",
          "Vi",
          "Sá"
        ],
        "monthNames": [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Septiembre",
          "Octubre",
          "Noviembre",
          "Diciembre"
        ],
      },
      startDate: moment(), // Establece la fecha de inicio como la fecha actual
      endDate: moment(),
      minDate: moment().startOf('month'),
      minDate: moment().startOf('day')
    });

    // Evita que el campo pierda la propiedad readonly
    inputFechas.on('focus', function () {
      $(this).blur();
    });
  });

  // Modal que aparece cuando se le hace clic al input de huespedes

  $("#inputHuespedes").click(function () {
    $(".modalHuespedes").show();
  });

  // Agregar un manejador de eventos de clic al documento
  $(document).on('click', function (event) {
    // Verificar si el clic ocurrió fuera del modal
    if (!$(event.target).closest('.modalHuespedes').length && !$(event.target).is('#inputHuespedes')) {
      $(".modalHuespedes").hide();
    }
  });

  // Añadir mas habitaciones en el modal de huespedes

  $(".btn-cancelar-habitacion").click(function () {
    $(".modalHuespedes").hide();
  });

  let inputCantHuespedes = $('#inputCantHuespedes');
  let inputHuespedes = $('#inputHuespedes');

  $(".btn-aplicar-cambios").click(function () {
    let valorInputCantH = inputCantHuespedes.val();

    let valorInputHuespedes = (valorInputCantH > 1) ? valorInputCantH + " huéspedes" : valorInputCantH + " huésped";

    inputHuespedes.val(valorInputHuespedes);
    $(".modalHuespedes").hide();
  });

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