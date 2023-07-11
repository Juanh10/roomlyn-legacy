//* Saber cuando ya se cargo correctamente el HTML

$(document).ready(function () {
    $('#onload').fadeOut(); //TODO Desaparece el elemento
    $('.cabeceraHab').show(); //TODO Muestra el elemento
    $('.btnWha').show();
    $('.flexslider').show();
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
      
      animacion('.cardHab','bottom', 1000, 200, '30px', 'ease-in-out');

});