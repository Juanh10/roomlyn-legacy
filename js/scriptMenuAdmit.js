$(document).ready(function () {

  $('.btnIconoMenu').click(function () {
    $('.menuLateral').toggleClass('activoMenu');
    $('body').toggleClass('activoBackground');
  });

  let enlacePrincipal = $('.enlacePrincipal');

  enlacePrincipal.click(function () {
    $('.flecha').toggleClass('flechaActivo');// agregar clase

    let height = 0;
    let menu = this.nextElementSibling; // seleccionar al hermano adyacente del elemento con la clase enlacePrincipal

    if (menu.clientHeight == 0) {
      height = menu.scrollHeight;
    }

    menu.style.height = `${height}px`;

  });

  $(document).click(function (event) {

    let menuLateral = $(".menuLateral");
    let btnMenuFijo = $('.btnIconoMenu');

    if (!$(event.target).closest(menuLateral).length && !$(event.target).closest(btnMenuFijo).length) {
      menuLateral.removeClass('activoMenu');
      $('body').removeClass('activoBackground');
    }
  });

  //* AGREGAR Y QUITAR CLASES A LOS ENLACES DEL MENU LATERAL FIJO

  let urlActual = window.location.href; // OBTENER LA URL ACTUAL

  $('.enlaceMenu').each(function () { // RECORRER TODAS LAS URL DEL MENU
    let href = $(this).attr('href'); // GUARDAR EL ATRIBUTO HREF DE LOS MENU

    if (urlActual.endsWith(href)) { // COMPARAR EL ATRIBUTO HREF CON LA URL ACTUAL
      $(this).addClass('activo'); // SI LA URL ACTUAL ES IGUAL AL HREF ME AGREGA LA CLASE ACTIVO
      return false; // ME RETORNA EL VALOR CUADNO ENCUENTRE EL ENLACE
    }
  });


  //* Agregar clase activo al menu desplegable del submenu
  $('.enlaceMenuSecund').each(function () {
    let href = $(this).attr('href');
    let submenu = $('.menuDesplegable');

    if (urlActual.endsWith(href)) {
      submenu.addClass('activo');
      return false;
    }
  });

  //* AGREGAR Y QUITAR CLASES A LOS ENLACES DEL MENU LATERAL


  $('.enlaceMenu2').each(function () { // RECORRER TODAS LAS URL DEL MENU
    let href2 = $(this).attr('href'); // GUARDAR EL ATRIBUTO HREF DE LOS MENU

    if (urlActual.endsWith(href2)) { // COMPARAR EL ATRIBUTO HREF CON LA URL ACTUAL
      $(this).addClass('activo'); // SI LA URL ACTUAL ES IGUAL AL HREF ME AGREGA LA CLASE ACTIVO
      return false; // ME RETORNA EL VALOR CUADNO ENCUENTRE EL ENLACE
    }
  });


  //* MOSTRAR DATOS DE SERVICIOS DE HABITACIONES PARA EDITAR

  $('.editServiciosBtn').click(function (e) {

    let elemento = e.target.parentElement.children;
    let arregloElemento = [...elemento];

    let datos = arregloElemento.map(function (element) {
      return $(element).text();
    });

    $('#idServicio').val(datos[0]);
    $('#servicioAct').val(datos[2]);

  });

  //* SCRIPTS PARA MOSTRAR LA INFORMACION DE LOS TIPOS DE HABITACIONES EN LA PLATAFORMA DEL ADMINISTRADOR, PARA ESTO SE USA LA API fetch para el envio del ID del tipo que se esta seleccionando

  const crud = $('.tipoHab button');
  const contCrud = $('#contenidoDelCrud');
  const btnEditTipo = $('#editTipo');

  crud.click(function (e) {
    let id = e.target.dataset.id; // obtener el valor del data-id en la cual es el id que seleccionó en el crud

    let url = `editTiposHabitaciones.php?id=${id}`; // obtenemos la url para editar los tipos de habitaciones

    $('#idTipoHabElm').val(id);

    btnEditTipo.attr('href', url);

    fetch(`../../vistas/vistasAdmin/tiposHabitaciones/mostrarTiposHabitaciones.php?id=${id}`) // usamos fetch para el envio de dtos
      .then(res => res.text()) // recibe la respuesta del servidor
      .then(datos => contCrud.html(datos)) // mostramos la respuesta
      .catch()
  });


  //* Enviar al servidor por medio de la api FETCH el id de la imagen para mostrarlo en el modal
  const btnActImg = $('.listImg2');
  const contenidoImg = $('#contenidoImg');
  const formularioRegTipoHabi = $('.formularioRegTipoHabi');

  btnActImg.click(function (e) {

    let idImg = e.target.id;
    let idTipoHab = formularioRegTipoHabi[0].id;

    fetch(`../../vistas/vistasAdmin/tiposHabitaciones/mostrarImgTipo.php?id=${idImg}&&idTipo=${idTipoHab}`) // enviamos el id al servidor por medio de fetch
      .then(res => res.text())
      .then(datos => contenidoImg.html(datos))
      .catch()
  });

  //* Eventos clic para agregar la foto sin tener que presionar un boton

  $('.addFoto').click(function () {
    $('#addImg').click(); // abrir el input de añadir imagen
  });

  $('#addImg').on('change', function (e) {
    if (e.target.files[0]) {
      $('#btnAddImg').click(); // evento de dar clic al boton de agregar cuando se agrega una imagen en el input file
    }
  });

  //* Enviar al servidor por medio de la api FETCH el id de la habitacion para la seccion de añadir imagen

  const btnAddServ = $('#btnAddServ');
  const contenidoServ = $('#modalAddServ2');

  btnAddServ.click(function (e) {

    let idTipoHab = e.target.id;

    fetch(`../vistasAdmin/tiposHabitaciones/mostrarServicios.php?id=${idTipoHab}`)// enviar el id al servidor por fetch
      .then(res => res.text()) // recibir los datos del servidor
      .then(datos => contenidoServ.html(datos)) // mostrar los datos
      .catch()
  });

  //* Enviar al servidor por medio de la api FETCH el id de la habitacion para editar el modulo de habitaciones
  const btnEditHab = $('.btnEditHab');
  const contenidoEditHab = $('#contaionerEditHabitaciones');

  btnEditHab.click(function (e) {
      let idHabitacion = e.target.parentElement.id;
  
      fetch(`../vistasAdmin/editarHabitaciones.php?id=${idHabitacion}`)
          .then(res => res.text())
          .then(datos => {
              contenidoEditHab.html(datos);
              $('#contaionerHabitaciones').hide(); // Oculta el contenedor
              $('.pie-de-pagina').hide();
          })
          .catch();
  });
  

  //* Enviar al servidor por medio de la api FETCH el id de la habitacion para editar el modulo de habitaciones
  const btnCambiarEstado = $('.btnCambEstado');
  const contenidoEstado = $('#modalCambEstado');

  btnCambiarEstado.click(function (e) {

    let idHabitacion = e.target.parentElement.id;


    fetch(`../vistasAdmin/cambiarEstado.php?id=${idHabitacion}`)
      .then(res => res.text())
      .then(datos => contenidoEstado.html(datos))
      .catch()

  });
  


  //* ALERTAS DE CONFIRMACIÓN

  setTimeout(function () {
    $('.alerta').fadeOut(500)
  }, 2000)

  function confirmarAccionFromulario(formElemento, message, resultado) {
    formElemento.submit(function (e) {
      e.preventDefault();

      const capThist = this;

      Swal.fire({
        title: '¿Estás seguro?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar'
      }).then((result) => {
        if (result.isConfirmed) {
          resultado.call(capThist); // Ejecutar la función de envío del formulario
        }
      });
    });
  }

  confirmarAccionFromulario($('.desHabitacion'), '¡No podrás revertir esto!', function () {
    this.submit();
  });

  confirmarAccionFromulario($('#formularioElimarTipo'), '¡No podrás revertir esto!', function () {
    this.submit();
  });

  confirmarAccionFromulario($('.formularioEliminar'), '¡No podrás revertir esto!', function () {
    this.submit();
  });



  function confirmarAccionBoton(botonElemento, message, resultado) {

    botonElemento.click(function (e) {

      Swal.fire({
        title: '¿Estas seguro?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar'
      }).then((result) => {
        if (result.isConfirmed) {
          resultado();
        }
      });

    });

  }

  confirmarAccionBoton($('.btnCerrarSesion'), "", function () { window.location.href = '../../procesos/login/conCerrarSesion.php'; });


  //! INICIALIZAR DATATABLES

  function initDatatables($tablaID) {

    $($tablaID).DataTable({

      "lengthMenu": [5, 10, 20, 30],

      responsive: true,

      "language": {
        "sEmptyTable": "No se encontraron registros",
        "sInfo": "Total de registros: _TOTAL_",
        "sInfoEmpty": "Mostrando 0 de 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sInfoThousands": ",",
        "sLengthMenu": "Mostrar _MENU_ registros por página",
        "sLoadingRecords": "Cargando...",
        "sProcessing": "Procesando...",
        "sSearch": "Buscar:",
        "sZeroRecords": "No se encontraron registros",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending": ": Activar para ordenar la columna ascendente",
          "sSortDescending": ": Activar para ordenar la columna descendente"
        }
      }
    });
  }

  initDatatables($('#tablaUsuarios'));
  initDatatables($('#tablaHabitaciones'));


  //* CONSULTA AJAX PARA FORMULARIO DEL REGISTRO DE HABITACIONES

  let tipoHab = $('#tipoHab');
  let inputAdd = $('#inputAgregado');

  tipoHab.on('change', function () {

    let seleccion = tipoHab.val();

    fetch(`../vistasAdmin/formTipoCama.php?id=${seleccion}`)
      .then(res => res.text())
      .then(datos => inputAdd.html(datos))
      .catch()

  });

});