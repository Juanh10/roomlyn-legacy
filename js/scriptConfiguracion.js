$(document).ready(function () {
    $('#onload').fadeOut(); //TODO Desaparece el elemento
    $('.cabecera').show(); //TODO Muestra el elemento


    // VER CONTRASEÑAS

    $('.inputContra').next('.verContraseña').click(function(){ // Por medio del evento clic capturamos el elemtno siguiente del input en este caso el icono de ver contraseña
        let contrInput = $(this).prev('.inputContra');
        let type = contrInput.attr('type');
        
        if (type === 'password') { // Verificamos si el tipo es password para campiarle el tipo a text
            contrInput.attr('type', 'text');
        } else {
            contrInput.attr('type', 'password');
        }
    });

    $('.inputContra2').next('.verContraseña2').click(function(){
        let contraInput2 = $(this).prev('.inputContra2');
        let type = contraInput2.attr('type');
        
        if (type === 'password') {
            contraInput2.attr('type', 'text');
        } else {
            contraInput2.attr('type', 'password');
        }
    })

    //* VALIDAR LAS CONTRASEÑAS QUE SEAN IGUALES

    let contra1 = $('.inputContra');
    let contra2 = $('.inputContra2');
    let msjVerificacion = $('.msjVerificacion');

    contra1.add(contra2).on('input', function(){

        let valorContra1 = contra1.val(); 
        let valorContra2 = contra2.val(); 

        if(valorContra1 !== valorContra2){
            msjVerificacion.css('display','block');
        }else{
            msjVerificacion.css('display','none');

        }

    });



    //* Alerta de verificacion

    $('.btnCerrarSesion').click(function (e) {
        
        Swal.fire({
            title: '¿Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Cerrar sesión'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../../procesos/login/conCerrarSesion2.php';
            }
        });
    });

    $('.formContra').submit(function (e) {
        e.preventDefault(); // sirve para parar lo que esta haciendo el navegador
        Swal.fire({
            title: '¿Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Cambiar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // sirve para enivar los datos del formulario
            }
        });
    });


    $('.formElmCuenta').submit(function (e) {
        e.preventDefault(); // sirve para parar lo que esta haciendo el navegador
        Swal.fire({
            title: '¿Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // sirve para enivar los datos del formulario
            }
        });
    });


    let menu = $('.navegacion ul');
    let icono = $('.icono');
    let nacionalidad = $('#nacionalidad');
    let departamento = $('#departamento');
    let ciudad = $('#ciudad');
    let idCliente = $('#idCliente');

    $(".menuRespon").click(function () {
        menu.toggleClass('mostrar');
        icono.toggleClass('iconoActivo');
    });

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
