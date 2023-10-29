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
      endDate: moment().add(1, 'day'),
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

  // Boton de cancelar que cierra el modal

  $(".btn-cancelar-habitacion").click(function () {
    $(".modalHuespedes").hide();
  });


  // Guardar la informacion del modal en el input

  let inputCantHuespedes = $('#inputCantHuespedes');
  let inputHuespedes = $('#inputHuespedes');

  $(".btn-aplicar-cambios").click(function () {
    let valorInputCantH = inputCantHuespedes.val();

    let valorInputHuespedes = (valorInputCantH > 1) ? valorInputCantH + " huéspedes" : valorInputCantH + " huésped";

    inputHuespedes.val(valorInputHuespedes);
    $(".modalHuespedes").hide();
  });

});