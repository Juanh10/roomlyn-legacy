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

    confirmarAccionFromulario($('#formsalRes'), '¡No podrás revertir esto!', function () {
        this.submit();
    });
    confirmarAccionFromulario($('#formCancelarRes'), '¡No podrás revertir esto!', function () {
        this.submit();
    });
    confirmarAccionFromulario($('#formConfirmRes'), '¡No podrás revertir esto!', function () {
        this.submit();
    });

});