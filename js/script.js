//* Saber cuando ya se cargo correctamente el HTML

$(document).ready(function() {
  $('#onload').fadeOut(); //TODO Desaparece el elemento
  $('.cabecera').show(); //TODO Muestra el elemento
  $('.btnWha').show();
  $('.flexslider').show();

  let iframeMapa = $('.mapaGoogle iframe');

  //* Saber si se cargó correctamente el iframe del mapa 
  iframeMapa.on('load', function(){
    $('#cargandoMapa2').fadeOut();
    $(this).show();
  });

});

$(document).ready(function() {
    //* USAR LA LIBRERIA FLEXSLIDER PARA EL CARRUSEL DE LA PAGINA
    $('.flexslider').flexslider({
        pauseOnAction: false,
        pauseOnHover: false,
        touch: true
    });

    //* AGREGAR Y QUITAR CLASES A LOS ENLACES DEL MENU 

    $(".enlaceMenu").click(function(){

        let enlace = $(this);
        
        $("a.activo").removeClass("activo");
        $(this).addClass("activo");

    });

    //* EVENTO CLICK PARA AGREGAR CLASE DE MENU RESPONSIVO 

    let menu = $('.navegacion ul');
    let icono = $('.icono');

    $(".menuRespon").click(function(){
        menu.toggleClass('mostrar');
        icono.toggleClass('iconoActivo');
    });

     //* EVENTO CLICK DE TODA LA PANTALLA PARA QUE AL HACER CLIC ALGUNA PARTE DE LA PANTALLA SE QUITE LA CLASE DEL MENU

    $(document).click(function(event) {

        let cabeceraMenu = $(".cabecera");
      
        if (!$(event.target).closest(cabeceraMenu).length) {
          menu.removeClass("mostrar");
          icono.removeClass('iconoActivo');
        }
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

      animacion('.cabecera','top', 1000, 200, '30px', 'ease-out');
      animacion('.descripcionHotel','left', 1000, 200, '30px', 'ease-out');
      animacion('.cardServicios','right', 1000, 200, '50px', 'ease-in-out');
      animacion('.contenedorImg','bottom', 1000, 200, '30px', 'ease-in-out');
      animacion('.mapa','left', 1000, 200, '30px', 'ease-out');

    
});