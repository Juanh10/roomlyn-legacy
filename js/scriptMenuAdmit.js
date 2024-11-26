$(document).ready(function () {

  $('.btnIconoMenu').click(function () {
    $('.menuLateral').toggleClass('activoMenu');
    $('body').toggleClass('activoBackground');
    $('.pie-de-pagina p').toggleClass('activoBackground2');
  });

  function subMenuDesplegable(id, icono){
    id.click(function () {
      $(icono).toggleClass('flechaActivo');// agregar clase
  
      let height = 0;
      let menu = this.nextElementSibling; // seleccionar al hermano adyacente del elemento con la clase enlacePrincipal
  
      if (menu.clientHeight == 0) {
        height = menu.scrollHeight;
      }
  
      menu.style.height = `${height}px`;
  
    });
  }

  subMenuDesplegable($('#flechaHabitaciones'),$('.iconHabitaciones'));
  subMenuDesplegable($('#flechaInventario'), $('.iconInventario'));
  subMenuDesplegable($('#flechaMenuHabitaciones'), $('.iconoHabitaciones'));
  subMenuDesplegable($('#flechaMenuInventario'), $('.IconoInventario'));

  $(document).click(function (event) {

    let menuLateral = $(".menuLateral");
    let btnMenuFijo = $('.btnIconoMenu');

    if (!$(event.target).closest(menuLateral).length && !$(event.target).closest(btnMenuFijo).length) {
      menuLateral.removeClass('activoMenu');
      $('body').removeClass('activoBackground');
      /* $('.pie-de-pagina p').removeClass('activoBackground2'); */
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

  //* Agregar clase activo al menu desplegable del submenu
  $('.enlaceMenuSecund_inventario').each(function () {
    let href = $(this).attr('href');
    let submenu = $('.menuDesplegable_inventario');

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

  //* Evento click para crear una habitacion mostrando un contenido y ocultando otro

  const btnAddHab = $('.btn-crear-habitacion');
  const contenidoAddHab = $('#containerAddHabitaciones');

  btnAddHab.click(function () {
    contenidoAddHab.load("crearHabitaciones.php");
    $('#contaionerHabitaciones').hide(); // Oculta el contenedor
    $('.pie-de-pagina').hide();
  })


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
    let archivo = "habitaciones";

    fetch(`../vistasAdmin/cambiarEstado.php?id=${idHabitacion}&archivo=${archivo}`)
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

  const contenidoArialLabelTablas = $('.tableAdmin').attr('aria-label');

  // fecha actual
  const actual = new Date();
  const opFormato = { year: 'numeric', month: '2-digit', day: '2-digit' };
  const formatoFecha = actual.toLocaleDateString('es-ES', opFormato);

  function initDatatables($tablaID) {

    // Verificar si la tabla ya tiene una instancia de DataTable
    if ($.fn.DataTable.isDataTable($tablaID)) {
      // Destruir la instancia existente antes de volver a inicializar
      $tablaID.DataTable().destroy();
    }

    $($tablaID).DataTable({
      "order": [],
      "bSort": false,
      "lengthMenu": [5, 10, 20, 30],
      responsive: true,

      dom: '<"dataTables_top"fB>t<"dataTables_bottom"lip>',

      buttons: [
        {
          extend: 'excelHtml5',
          text: '<i class="bi bi-file-earmark-excel-fill"></i>',
          titleAttr: 'Exportar a Excel',
          className: 'btn btn-success',
          filename: function () {
            return `reporte_${contenidoArialLabelTablas}`;
          },
          title: `Hotel Colonial City - Reporte de ${contenidoArialLabelTablas}`,
          messageTop: function () {
            return `Fecha de exportación: ${formatoFecha}`;
          },
          exportOptions: {
            columns: ':not(.no-export)'
          }
        },

        {
          extend: 'pdfHtml5',
          text: '<i class="bi bi-file-earmark-pdf-fill"></i>',
          titleAttr: 'Exportar a PDF',
          className: 'btn btn-danger',
          filename: function () {
            return `reporte_${contenidoArialLabelTablas}`;
          },
          title: '',
          exportOptions: {
            columns: ':not(.no-export)'
          },
          customize: function (doc) {
            try {
              //orientacion y margenes
              doc.pageOrientation = 'portrait';
              doc.pageMargins = [40, 0, 40, 40];

              //array de columnas para colocar el logo y el texto
              doc.content.unshift({
                columns: [
                  {
                    // Columna para el logo
                    image: logoBase64,
                    width: 150, // Ajustar el ancho según sea necesario
                    alignment: 'left', // Alinear el logo a la izquierda
                    margin: [0, 0, 20, 20] // Espaciado a la derecha del logo
                  },
                  {
                    stack: [
                      {
                        text: 'Hotel Colonial City',
                        fontSize: 16,
                        bold: true,
                        margin: [0, 0, 0, 5]
                      },
                      {
                        text: 'Calle 10 Número 3-03',
                        fontSize: 11,
                        margin: [0, 0, 0, 3]
                      },
                      {
                        text: `Reporte de ${contenidoArialLabelTablas}`,
                        fontSize: 11,
                        margin: [0, 0, 0, 3]
                      },
                      {
                        text: formatoFecha,
                        fontSize: 11
                      }
                    ],
                    alignment: 'right'
                  }
                ],
                margin: [10, 12, 0, 12] // Margen general para la fila
              });

              // estilos de la tabla
              doc.styles.tableHeader = {
                fillColor: '#c4ac9f',
                color: '#000',
                bold: true,
                fontSize: 11,
                alignment: 'center'
              };

              // estilo general del documento
              doc.defaultStyle = {
                fontSize: 10,
                alignment: 'center'
              };

              // pie de página
              doc.footer = function (currentPage, pageCount) {
                return {
                  text: 'Página ' + currentPage.toString() + ' de ' + pageCount,
                  alignment: 'center',
                  fontSize: 8,
                  margin: [0, 10, 0, 0]
                };
              };

            } catch (e) {
              console.error('Error al personalizar el PDF:', e);
            }
          }
        },

        {
          extend: 'print',
          text: '<i class="bi bi-printer-fill"></i>',
          titleAttr: 'Imprimir',
          title: ' ',
          className: 'btn btn-info',
          exportOptions: {
            columns: ':not(.no-export)'
          },
          customize: function (win) {
            try {
              // Estilos para la ventana de impresión
              $(win.document.body)
                .css('font-size', '12pt') // Ajustar el tamaño de la fuente general
                .css('text-align', 'center'); // Alinear todo el contenido al centro

              // Añadir el logo
              $(win.document.body).prepend(
                `<div style="text-align: left; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                  <div style="width: 50%; margin-right: 20px;">
                    <img src="${logoBase64}" style="max-width: 100%; height: auto;" />
                  </div>
                  <div style="display: inline-block; text-align: left;">
                    <h1 style="margin: 0;">Hotel Colonial City</h1>
                    <p style="margin: 0;">Calle 10 Número 3-03</p>
                    <p style="margin: 0;">Reporte de ${contenidoArialLabelTablas}</p>
                    <p style="margin: 0;">${formatoFecha}</p>
                  </div>
                </div>`
              );

              // Estilos de la tabla
              $(win.document.body).find('table')
                .addClass('table-bordered')
                .css('width', '100%') // Hacer la tabla de ancho completo
                .css('font-size', 'inherit'); // Mantener tamaño de fuente

              // Actualizar los números de página
              $(win).on('afterprint', function () {
                $(this).off('afterprint'); // Limpiar el evento después de usarlo
              });
            } catch (e) {
              console.error('Error al personalizar la impresión:', e);
            }
          }
        },
      ],

      "language": {
        "sEmptyTable": "No se encontraron registros",
        "sInfo": "Total de registros: _TOTAL_",
        "sInfoEmpty": "Mostrando 0 de 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sLoadingRecords": "Cargando...",
        "sProcessing": "Procesando...",
        "sSearch": "Buscar:",
        "sZeroRecords": "No se encontraron registros",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        }
      }
    });
  }


  initDatatables($('#tablaUsuarios'));
  initDatatables($('#tablaClientes'));
  initDatatables($('#tablaClientesFiltro'));
  initDatatables($('#tablaHabitaciones'));
  initDatatables($('#tablaReservas'));
  initDatatables($('#tablaReservasFiltro'));
  //initDatatables($('#tablaCategorias'));

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

  /* PETICION AJAX PARA FILTROS POR SELECT */
  $('#selectFiltro').change(function () {

    let seleccion = $(this).val();

    $.ajax({
      type: 'POST',
      url: 'filtrosSelectRecepcion.php',
      data: {
        seleccion: seleccion
      },
      success: function (respuesta) {
        $('#contenedorCardInicial').hide();
        /* $('.filtrosReserva').hide(); */
        $('#contenedorCardFiltro').html(respuesta);
      }
    });
  });

  //* BUSCADOR PARA LAS HABITACIONES

  $('#buscadorHab').on('keyup', function () {
    //Obtener el texto ingresado en el input
    let inputText = $(this).val().toLowerCase();
    let resultadosEncontrados = false;

    // Recorrer por la informacion de las habitaciones para capturar el numero de habitacion
    $('.cardHabitaciones').each(function () {
      let numHabitacion = $(this).find('.numHabitacion span').text().toLowerCase(); // capturar el numero de habitacion

      if (numHabitacion.indexOf(inputText) === -1) { // comparamos que el numero de habitacion coincida con la busqueda
        $(this).hide(); // ocultamos las demas habitaciones
      } else {
        $(this).show(); // mostramos la habitacion buscada
        resultadosEncontrados = true;
      }
    });

    // Mostrar u ocultar el mensaje según si se encontraron resultados
    if (resultadosEncontrados) {
      $('#mensajeNoResultados').hide();
    } else {
      $('#mensajeNoResultados').show();
    }
  });

  // FILTRAR POR FECHAS

  function setFechaActual() {
    let fechaActual = new Date();

    // Establecer la zona horaria en Bogotá
    fechaActual.setUTCHours(fechaActual.getUTCHours() - 5);

    // Formatear la fecha como ISO y establecerla en los elementos HTML
    let fechaFormateada = fechaActual.toISOString().split('T')[0];
    $('#fechaInicio, #fechaFinal').val(fechaFormateada);
  }

  // evento clic para llamar la funcion de filtrar las fechas
  $('#btnFiltrar').on('click', function () {
    setFechaActual();
  });


  // ENVIO DE DATOS POR MEDIO DE AJAX

  $('#filtroBtnFechaRes').click(function () {
    // Obtener las fechas seleccionadas
    let fechaInicial = $('#fechaInicio').val();
    let fechaFinal = $('#fechaFinal').val();
    let estado = $('#selectFiltroEstado').val();

    // Realizar la petición AJAX c
    $.ajax({
      type: 'POST',
      url: 'reservacionesFiltro.php',
      data: {
        fechaInicial: fechaInicial,
        fechaFinal: fechaFinal,
        estado: estado
      },
      success: function (response) {
        $('#contenedorIniReservaciones').hide();
        $('#modalFiltrarFecha').modal('hide');
        $('#contenedorFilReservaciones').html(response);
      }
    });
  });


  /* FUNCION PARA MOSTRAR INFORMACION RELEVANTE DE LAS RESERVACIONES */

  $('.desplegarInformacionRecep').click(function () {
    $('.cardInformacion').toggle()
  });


  $('#filtroBtnFechaCli').click(function () {
    // Obtener las fechas seleccionadas
    let fechaInicial = $('#fechaInicio').val();
    let fechaFinal = $('#fechaFinal').val();

    // Realizar la petición AJAX 
    $.ajax({
      type: 'POST',
      url: 'clientesFiltro.php',
      data: {
        fechaInicial: fechaInicial,
        fechaFinal: fechaFinal
      },
      success: function (response) {
        $('#contenedorPrincipalCli').hide();
        $('#modalFiltrarFecha').modal('hide');
        $('#contenedorFiltroCli').html(response);
      }
    });
  });

});