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
  const retrasoCaptura = 500; // milisegundos

  // funcion para mantener el foco del input
  function mantenerFoco() {
    inputNfc.focus();
  }

  // el intervalo sirve para que se mantenga el foco del input

  // funcion para capturar el codigo NFC
  function procesarCodigoNFC(codigo) {
    console.log('Código completo del llavero:', codigo);

    //procesar codigo NFC

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

  // agregar el foco cuando el modal está abierto
  modal.on('shown.bs.modal', function () {
    inputNfc.val(''); // limpiar el input
    mantenerFoco();

    intervaloFoco = setInterval(mantenerFoco, 100);
  });


  inputNfc.on('input', function () {

    clearTimeout(temporizadorCaptura);

    temporizadorCaptura = setTimeout(() => {
      const codigoNFC = $(this).val();
      if (codigoNFC.length > 0) {
        procesarCodigoNFC(codigoNFC);
      }
    }, retrasoCaptura);
  });

  // limpiar intervalos y temporizadores cuando se cierra el modal
  modal.on('hidden.bs.modal', function () {
    clearInterval(intervaloFoco);
    clearTimeout(temporizadorCaptura);
  });

  /*  $('.buscadorNfc').click(function(){
     contenidoMain.hide();
     contenidoNfc.show();
   }); */

  // DRIVER JS

  const driver = window.driver.js.driver;

  if(!localStorage.getItem('mensajeMostrado')){

    const driverObj = driver({
      showProgress: false,
      steps: [
        {
          element: '.btn-buscadorNfc',
          popover: {
            title: 'Buscar habitaciones con NFC',
            description: 'Este botón te permite buscar habitaciones utilizando el llavero, solo necesitas acercarlo al sensor. A través de esta función, podrás ver el historial del cliente, incluyendo su factura, lo que ha consumido durante su estadía, entre otros detalles relacionados con la habitación.',
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