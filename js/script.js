$(document).ready(function () {
  // Esconder elementos al cargar el documento
  $('#onload').fadeOut();
  $('.cabecera, .btnWha, .flexslider').show();


  let iframeMapa = $('.mapaGoogle iframe');

  //* Saber si se cargó correctamente el iframe del mapa 
  iframeMapa.on('load', function () {
    $('#cargandoMapa2').fadeOut();
    $(this).show();
  });

  // ALERTA DE CONFIRMACIÓN al cerrar sesión
  $('#btncerrarSesionCliente').click(function (e) {
    Swal.fire({
      title: '¿Estás seguro?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Cerrar sesión'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'procesos/login/conCerrarSesion2.php';
      }
    });
  });

  // USAR LA LIBRERIA FLEXSLIDER PARA EL CARRUSEL DE LA PÁGINA
  $('.flexslider').flexslider({
    pauseOnAction: false,
    pauseOnHover: false,
    touch: true
  });

  // AGREGAR Y QUITAR CLASES A LOS ENLACES DEL MENÚ
  $(".enlaceMenu").click(function () {
    $(".enlaceMenu.activo").removeClass("activo");
    $(this).addClass("activo");
  });

  let menu = $('.navegacion ul');
  let icono = $('.icono');

  // EVENTO CLICK PARA AGREGAR CLASE DE MENÚ RESPONSIVO
  $(".menuRespon").click(function () {
    menu.toggleClass('mostrar');
    icono.toggleClass('iconoActivo');
  });

  // EVENTO CLICK PARA QUITAR CLASE DEL MENÚ AL HACER CLIC EN OTRA PARTE DE LA PANTALLA
  $(document).click(function (event) {
    let cabeceraMenu = $(".cabecera");
    if (!$(event.target).closest(cabeceraMenu).length) {
      menu.removeClass("mostrar");
      icono.removeClass('iconoActivo');
    }
  });

  // LIBRERÍA PARA LA GALERÍA DE IMÁGENES CON EFECTO LIGHTBOX
  lightbox.option({
    'resizeDuration': 300,
    'wrapAround': true,
    'fitImagesInViewport': true,
    'imageFadeDuration': 200,
    'showImageNumberLabel': true,
    'albumLabel': "Imagen %1 de %2",
    'disableScrolling': true,
  });

  // LIBRERÍA PARA CONTROLAR LAS ANIMACIONES
  const sr = ScrollReveal();

  // Función para crear animaciones con parámetros
  const animacion = (clase, origen, duracion, delay, distancia, ease) => {
    sr.reveal(clase, {
      origin: origen,
      duration: duracion,
      delay: delay,
      distance: distancia,
      easing: ease
    });
  };

  // Aplicar animaciones con la función creada
  animacion('.cabecera', 'top', 1000, 200, '30px', 'ease-out');
  animacion('.descripcionHotel', 'left', 1000, 200, '30px', 'ease-out');
  animacion('.cardServicios', 'right', 1000, 200, '50px', 'ease-in-out');
  animacion('.mapa', 'left', 1000, 200, '30px', 'ease-out');
});