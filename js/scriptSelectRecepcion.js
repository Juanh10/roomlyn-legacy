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

});