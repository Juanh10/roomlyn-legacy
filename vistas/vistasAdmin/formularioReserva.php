<?php

session_start();

date_default_timezone_set('America/Bogota');

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

include "../vistasHabitaciones/funcionesIconos.php";

$estadoId = false;
$pagFiltro = false;

// Obtener la URL de la pagina actual
$urlActual = $_SERVER['HTTP_REFERER'];

if (!empty($_GET['idHabitacion'])) { // Condicion para saber si los campos no estan vacios

    if (!empty($_GET['totalFactura'])) {
        $totalFactura = $_GET['totalFactura'];
    } else {
        $totalFactura = 0;
    }

    $habitacion = $_GET['idHabitacion'];
    $tipoHabitacion = $_GET['idTipoHab'];

    $checkin = $_GET['checkin'];
    $checkout = $_GET['checkout'];

    $sqlHabitacion = "SELECT id_habitacion, id_hab_tipo, id_hab_estado, nHabitacion, tipoCama, cantidadPersonasHab, observacion, estado FROM habitaciones WHERE id_habitacion = " . $habitacion . " AND estado = 1";

    $rowHabitacion = $dbh->query($sqlHabitacion)->fetch();

    $sqlTipoHab = "SELECT id_hab_tipo, tipoHabitacion, cantidadCamas, estado FROM habitaciones_tipos WHERE id_hab_tipo = " . $tipoHabitacion . " AND estado = 1";

    $rowTipoHab = $dbh->query($sqlTipoHab)->fetch();

    $sqlimagenesTipoHab = "SELECT nombre, ruta, estado FROM habitaciones_imagenes WHERE estado = 1 AND id_hab_tipo = " . $tipoHabitacion . "";

    $rowImgTipoHab = $dbh->query($sqlimagenesTipoHab)->fetch();

    $estadoId = true;
} else {
    echo "Ocurrió un error en esta parte";
}

?>

<h2>Datos</h2>


<form action="../../procesos/registroReservas/conRegistroReservaAdmin.php" method="post" id="form" class="formReservasClienteNoReg">
    <div class="row">
        <div class="col-6 responsive-col-form">

            <input type="hidden" id="tipoHab" name="tipoHab" value="<?php echo $tipoHabitacion ?>">
            <input type="hidden" id="habitacion" name="habitacion" value="<?php echo $habitacion ?>">
            <input type="hidden" id="totalFactura" name="totalFactura" value="<?php echo $totalFactura ?>">

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Nombres" required>
                <p></p>
                <label for="nombres">Nombres</label>
            </div>

            <div class="form-floating mb-3">
                <?php
                if ($pagFiltro) :
                ?>
                    <input type="date" class="form-control" id="fechaEntrada" placeholder="Nombres" name="checkIn" value="<?php echo $checkin ?>" required>
                <?php
                else :
                ?>
                    <input type="date" class="form-control" id="fechaEntrada" placeholder="Nombres" name="checkIn" value="<?php echo $checkin ?>" required>
                <?php
                endif;
                ?>
                <p></p>
                <label for="fechaEntrada">Fecha de llegada</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="documento" class="form-control" id="documento" placeholder="Documento" required>
                <p></p>
                <label for="documento">Documento</label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                <p></p>
                <label for="email">Email</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" name="nacionalidad" id="nacionalidad" required>
                    <option selected disabled value="">Escoja una opción</option>
                    <?php
                    $sqlNacionalidad = "SELECT id_nacionalidad, nacionalidad FROM nacionalidades WHERE 1";

                    foreach ($dbh->query($sqlNacionalidad) as $rowNacionalidad) :
                        if ($rowNacionalidad['id_nacionalidad'] != 1) :
                    ?>
                            <option value="<?php echo $rowNacionalidad['id_nacionalidad'] ?>"><?php echo $rowNacionalidad['nacionalidad'] ?></option>
                    <?php
                        endif;
                    endforeach;

                    ?>
                </select>
                <label for="nacionalidad">Nacionalidad</label>
            </div>

            <div class="form-floating mb-3" id="selectCiudad">
                <select class="form-select" name="ciudad" id="ciudad" required>

                </select>
                <label for="ciudad">Ciudad de origen</label>
            </div>

        </div>
        <div class="col-6">

            <div class="form-floating mb-3">
                <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Apellidos" required>
                <p></p>
                <label for="apellidos">Apellidos</label>
            </div>

            <div class="form-floating mb-3">
                <?php
                if ($pagFiltro) :
                ?>
                    <input type="date" class="form-control" id="fechaSalida" placeholder="Nombres" name="checkOut" value="<?php echo $checkout ?>" required>
                <?php
                else :
                ?>
                    <input type="date" class="form-control" id="fechaSalida" placeholder="Nombres" name="checkOut" value="<?php echo $checkout ?>" required>
                <?php
                endif;
                ?>
                <p></p>
                <label for="fechaSalida">Fecha de salida</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Teléfono" required>
                <p></p>
                <label for="telefono">Teléfono</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" name="sexo" id="sexo" required>
                    <option selected disabled value="">Escoja una opción</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
                <p></p>
                <label for="sexo">Sexo</label>
            </div>

            <div class="form-floating mb-3" id="selectDepartamento">
                <select class="form-select" name="departamento" id="departamento" required>

                </select>
                <label for="departamento">Departamento</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="montoReserva" name="montoReserva" value="0" placeholder="Cantidad a abonar">
                <p></p>
                <label for="montoReserva">Cantidad a abonar</label>
            </div>

        </div>
    </div>
    <div class="formularioMensaje">
        <p><i class="bi bi-exclamation-circle-fill"></i>¡Por favor rellene los campos correctamente!</p>
    </div>

    <div class="btnReservar">
        <input type="submit" name="btnReservar" value="Reservar" id="btnResClnNoReg">
    </div>


    <script src="../../js/validarRegistroReserva.js"></script>

    <script>
        // Funcion para quitar las tildes
        function removeDiacritics(text) {
            return text.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        }

        $(document).ready(function() {

            //* ALERTA DE CONFIRMACION DEL FORMULARIO

            $('.formReservas').submit(function(e) {
                e.preventDefault(); // sirve para parar lo que esta haciendo el navegador
                Swal.fire({
                    title: '¿Estas seguro de realizar la reserva?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // sirve para enivar los datos del formulario
                    }
                });
            });

            // INICIALIZAR LA LIBRERIA DE SELECT2

            $('#nacionalidad').select2();
            $('#departamento').select2();
            $('#ciudad').select2();

            // FUNCION PARA RECARGAR LA LISTA DE DEPARTAMENTOS Y CIUDADES POR MEDIO DE AJAX O FETCH
            function listaOrigenDepartamento() {
                let valorNacionalidad = $('#nacionalidad').val();
                let divDepartamento = $('#departamento');
                let divCiudad = $('#ciudad');

                // Realizar una consulta fetch para mostrar los departamentos
                fetch(`reservas/selectOrigen.php?valorNa=${valorNacionalidad}`)
                    .then(res => res.text())
                    .then(datos => {
                        divDepartamento.html(datos);

                        // Si el valor de nacionalidad no es igual a 43, que cargue la opcion "No requerido"
                        if (valorNacionalidad != 43) {
                            fetch(`reservas/selectOrigenCiudad.php?valorDe=0`)
                                .then(resCiudad => resCiudad.text())
                                .then(datosCiudad => divCiudad.html(datosCiudad))
                                .catch();
                        }
                    })
                    .catch();
            }

            listaOrigenDepartamento(); // Ejecutar la funcion

            $('#nacionalidad').change(function() { // evento change para saber cuando hay un cambio en el select
                listaOrigenDepartamento();
            });

            // Funcion para mostrar la lista de las ciudades segun el departamento esto lo hacemos por medio de FETCH

            function listaOrigenCiudad() {
                let valorDepartamento = $('#departamento').val();
                let divCiudad = $('#ciudad');

                // Realiza una única llamada a la función fetch para cargar las ciudades
                fetch(`reservas/selectOrigenCiudad.php?valorDe=${valorDepartamento}`) // realizar consulta fetch
                    .then(res => res.text())
                    .then(datos => divCiudad.html(datos))
                    .catch();
            }

            listaOrigenCiudad(); // ejecutar la funcion

            $('#departamento').change(function() { // evento change para saber cuando hay un cambio en el select
                listaOrigenCiudad();
            });


            // Funcion para validar el campo de monto abonado lo tengo en un script aparte porque el archivo validarRegistroReserva tambien se usa en otros formularios de reserva y en los otros no está el campo de monto abonado
            const validarCampos = (expresion, input, idCampo, message) => {
                if (expresion.test(input.value)) {
                    $(`#${idCampo}`).removeClass('validarInput');
                    $(`#${idCampo}`).next('p').removeClass('error');
                    $(`#${idCampo}`).next('p').text("");
                    estadoInput[idCampo] = true;
                } else {
                    $(`#${idCampo}`).addClass('validarInput');
                    $(`#${idCampo}`).next('p').addClass('error');
                    $(`#${idCampo}`).next('p').text(message);
                    estadoInput[idCampo] = false;
                }
            };

            const expresionNumeros = /^[0-9]+$/; // Expresion para poder identificar solamente numeros

            // Evento input para saber cambio el elemento input del HTML 
            $('#montoReserva').on('input', function() {
                const monto = $(this).val();
                validarCampos(expresionNumeros, this, 'montoReserva', 'Por favor ingrese un monto válido'); // llamamos la funcion para validar los campos 
            });

        });
    </script>
    </body>

    </html>