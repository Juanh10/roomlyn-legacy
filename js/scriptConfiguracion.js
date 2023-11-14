$(document).ready(function () {
    // Ocultar elementos al cargar
    $('#onload').fadeOut();
    $('.cabecera').show();

    // Función para mostrar/ocultar contraseña
    function estadoContraseña(inputElement) {
        let type = inputElement.attr('type');
        if (type === 'password') {
            inputElement.attr('type', 'text');
        } else {
            inputElement.attr('type', 'password');
        }
    }

    $('.verContraseña').click(function () {
        estadoContraseña($(this).prev('.inputContra'));
    });

    $('.verContraseña2').click(function () {
        estadoContraseña($(this).prev('.inputContra2'));
    });

    // Validar contraseñas iguales
    $('.inputContra, .inputContra2').on('input', function () {
        const contra1 = $('.inputContra').val();
        const contra2 = $('.inputContra2').val();
        const msjVerificacion = $('.msjVerificacion');

        msjVerificacion.css('display', contra1 !== contra2 ? 'block' : 'none');
    });

    // Alerta de confirmación
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

    confirmarAccionFromulario($('.formContra'), '¡No podrás revertir esto!', function() {
        this.submit(); 
    });
    confirmarAccionFromulario($('.formElmCuenta'), '¡No podrás revertir esto! ¿Deseas eliminar la cuenta?', function() {
        this.submit(); 
    });

    function confirmarAccionBoton(botonElemento, message, resultado){

        botonElemento.click(function(e){

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

    confirmarAccionBoton($('.btnCerrarSesion'), "¡No podrás revertir esto!", function(){window.location.href = '../../procesos/login/conCerrarSesion2.php';})

    // Manipulación del menú responsivo
    const menu = $('.navegacion ul');
    const icono = $('.icono');

    $(".menuRespon").click(function () {
        menu.toggleClass('mostrar');
        icono.toggleClass('iconoActivo');
    });

    let nacionalidad = $('#nacionalidad');
    let departamento = $('#departamento');
    let ciudad = $('#ciudad');
    let idCliente = $('#idCliente');

    nacionalidad.select2();
    departamento.select2();
    ciudad.select2();

    function listaOrigenDepartamento(urFetch) {
        fetch(urFetch)
            .then(res => res.text())
            .then(datos => {
                departamento.html(datos);

                if (nacionalidad.val() !== "43") {
                    fetch(`selectCiudad2.php?valorDe=0&vCliente=${idCliente.val()}`)
                        .then(resCiudad => resCiudad.text())
                        .then(datosCiudad => ciudad.html(datosCiudad))
                        .catch(error => console.error(error));
                }
            })
            .catch(error => console.error(error));
    }

    listaOrigenDepartamento(`selectDepartamento2.php?valorNa=${nacionalidad.val()}&vCliente=${idCliente.val()}`);

    nacionalidad.change(function () {
        listaOrigenDepartamento(`selectDepartamento2.php?valorNa=${nacionalidad.val()}&vCliente=${idCliente.val()}&event=1`);
        listaOrigenCiudad();
    });

    function listaOrigenCiudad() {
        let valorDepartamento = departamento.val();

        fetch(`selectCiudad2.php?valorDe=${valorDepartamento}&vCliente=${idCliente.val()}`)
            .then(res => res.text())
            .then(datos => ciudad.html(datos))
            .catch(error => console.error(error));
    }

    listaOrigenCiudad();

    departamento.change(function () {
        listaOrigenCiudad();
    });
});