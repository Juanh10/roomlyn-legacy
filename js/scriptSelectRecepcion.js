$(document).ready(function () {

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

  confirmarAccionFromulario($('#formCancelarRes'), '¡No podrás revertir esto!', function () {
    this.submit();
  });

  confirmarAccionFromulario($('#formConfirmRes'), '¡No podrás revertir esto!', function () {
    this.submit();
  });

  $('.btnOcupado').click(function () {
    let idHabitacion = $(this).attr('id');
    let contenido = $('#inforClienteOcupado');

    fetch(`../vistasAdmin/inforClienteOcupado.php?id=${idHabitacion}`)
      .then(res => res.text())
      .then(datos => contenido.html(datos))
      .catch();
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

  const contenidoNfc = $('#contenido-buscadorNfc');
  const contenidoMain = $('.lisTiposHb');
  const modal = $('#modal-buscadorNfc');
  const inputNfc = $('#codNfc');
  let intervaloFoco;
  let temporizadorCaptura;
  const retrasoCaptura = 500; // ms

  // Funcion para mantener el foco del input
  function mantenerFoco() {
    inputNfc.focus();
  }

  // Funcion para procesar el código NFC
  function procesarCodigoNFC(codigo) {
    fetch(`../vistasAdmin/mostrarContenidoNfc.php?codigo=${codigo}`)
      .then(res => res.text())
      .then(datos => {
        contenidoNfc.html(datos);
        contenidoMain.hide();
        contenidoNfc.show();
        clearInterval(intervaloFoco);
        inputNfc.blur();
        modal.modal('hide');
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  // Agregar el foco cuando el modal está abierto
  modal.on('shown.bs.modal', function () {
    inputNfc.val(''); // Limpiar el input
    mantenerFoco();

    // Mantener el foco cada 100 ms
    intervaloFoco = setInterval(mantenerFoco, 100);
  });

  // Evento input para capturar el código del NFC
  inputNfc.on('input', function () {
    clearTimeout(temporizadorCaptura);

    temporizadorCaptura = setTimeout(() => {
      const codigoNFC = $(this).val().trim();

      // Si el código NFC tiene longitud mayor que 0, procesarlo y enviarlo
      if (codigoNFC.length > 0) {
        procesarCodigoNFC(codigoNFC);
      }
    }, retrasoCaptura);
  });

  // Limpiar intervalos y temporizadores cuando se cierra el modal
  modal.on('hidden.bs.modal', function () {
    clearInterval(intervaloFoco);
    clearTimeout(temporizadorCaptura);
  });

  // DRIVER JS

  const driver = window.driver.js.driver;

  if (!localStorage.getItem('mensajeMostrado')) {

    const driverObj = driver({
      showProgress: false,
      steps: [
        {
          element: '.btn-buscadorNfc',
          popover: {
            title: 'Buscar reservas con NFC',
            description: 'Haz clic en el botón para ver información de una reservación. Una vez que lo hagas, podrás visualizar detalles importantes como el número de la reserva, el estado actual, fechas de entrada y salida, así como cualquier solicitud o servicio adicional que hayas solicitado.',
            side: "bottom",
            align: 'center'
          }
        }
      ],
      doneBtnText: 'Aceptar',
      nextBtnText: 'Siguiente',
      prevBtnText: 'Anterior',
    });

    driverObj.drive();

    // guardar en localStorage 
    localStorage.setItem('mensajeMostrado', 'true');
  }


});