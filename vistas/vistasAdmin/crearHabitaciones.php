<?php
session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

$sql = "SELECT id_hab_tipo, tipoHabitacion FROM habitaciones_tipos WHERE 1 AND estado = 1"; //consulta para el modal de añadir habitaciones

$sql2 = "SELECT habitaciones.id_habitacion, habitaciones.id_servicio, habitaciones.nHabitacion, habitaciones_tipos.tipoHabitacion, habitaciones.tipoCama, habitaciones.cantidadPersonasHab, habitaciones.observacion, habitaciones.estado, habitaciones_estado.estado_habitacion FROM habitaciones INNER JOIN habitaciones_tipos ON habitaciones.id_hab_tipo = habitaciones_tipos.id_hab_tipo INNER JOIN habitaciones_estado ON habitaciones.id_hab_estado = habitaciones_estado.id_hab_estado WHERE habitaciones.estado = 1 ORDER BY habitaciones.id_habitacion"; // consulta para mostrar todos los datos relacionados con las habitacione.

?>


<!DOCTYPE html>
<html lang="es">

<body>

    <form action="../../procesos/registroHabitaciones/registroHabi/conRegistroHabitaciones.php" method="post" id="formRegHab">
        <div class="container">
            <div class="row">
                <span class="btnVolverHab">
                    < Volver</span>
                        <div class="col-md-7 me-5">


                            <h1 class="tituloPrincipal mb-4">Añadir habitación</h1>

                            <label for="numHabitacion">Número de la habitación</label>
                            <input type="number" class="form-control mt-2" min="0" name="numHabitacion" id="numHabitacion" required>
                            <p></p>

                            <label for="tipoHab">Tipo de habitación</label>
                            <select class="form-select mt-2" name="tipoHab" id="tipoHab" required>
                                <option disabled selected value="">Escoja una opción</option>
                                <?php
                                foreach ($dbh->query($sql) as $row) :
                                ?>
                                    <option value="<?php echo $row['id_hab_tipo'] ?>"><?php echo $row['tipoHabitacion'] ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                            <p></p>

                            <div id="inputAgregado">
                                <?php
                                include "formTipoCama.php"; // incluimos para añadir los demas inputs segun el tipo de habitacion escogida
                                ?>
                            </div>

                            <label class="mt-2" for="sisClimatizacion">Sistema de climatización</label>
                            <select class="form-select mt-2" name="sisClimatizacion" id="sisClimatizacion">
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="1">Ventilador</option>
                                <option value="2">Aire acondicionado</option>
                            </select>
                            <p></p>

                            <label for="observaciones" class="mt-2">Observaciones</label>
                            <textarea class="form-control mt-2" name="observaciones" id="observaciones" required></textarea>
                            <p></p>
                        </div>
                        <div class="col-4 responsiveServicios">
                            <div class="serviciosHabitaciones">
                                <h1 class="tituloServicios mb-0"><i class="bi bi-check-square"></i> Elementos</h1>

                                <?php

                                $sqlElemento = "SELECT id_hab_elemento, elemento FROM habitaciones_elementos WHERE 1";

                                foreach ($dbh->query($sqlElemento) as $rowElemento) :
                                ?>
                                    <div class="form-check serviciosCheck border border-bottom">
                                        <label for="" class="ocularIdServi"><?php echo $rowElemento['id_hab_elemento'] ?></label>
                                        <input class="form-check-input inputCheck ms-1" type="checkbox" id="<?php echo $rowElemento['elemento'] ?>" value="<?php echo $rowElemento['id_hab_elemento'] ?>" name="opcionesServ[]">
                                        <label class="form-check-label" for="<?php echo $rowElemento['elemento'] ?>"><?php echo $rowElemento['elemento'] ?></label>

                                        <span class="btn btn-sm editServiciosBtn bi bi-pencil-square" data-bs-toggle="modal" data-bs-target="#actualizarServicios" title="Editar"></span>
                                    </div>
                                <?php
                                endforeach;
                                ?>

                                <!-- BOTON PARA AÑADIR MAS SERVICIOS -->
                                <div class="botonRegServi">
                                    <span class="btnServicio" data-bs-toggle="modal" data-bs-target="#modalRegServ">Registrar Elemento</span>
                                </div>
                            </div>
                            <div>
                                <span id="mensajeErrorServicio">Debes seleccionar al menos un servicio</span>
                            </div>
                        </div>
                        <div class="formularioMensaje">
                            <p>¡Por favor rellene todos los campos!</p>
                        </div>
            </div>
        </div>
        <div class="btn-guardar-habitacion">
            <button class="boton-guardar-hab" id="btn-add">Añadir</button>
            <!-- <input type="submit" value="Añadir" name="añadirHab" class="boton-guardar-hab"> -->
        </div>

        <!-- MODAL PARA REGISTRAR NFC -->

        <div class="modal fade" id="registrarNfc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Acercar el llavero al sensor</p>
                        <input type="text" id="codNfc">
                    </div>
                </div>
            </div>
        </div>

    </form>


    <!-- ALERTAS -->

    <?php

    if (isset($_SESSION['msjExito'])) :
    ?>
        <div class="alert alert-success alerta" role="alert">
            <strong><i class="bi bi-check-circle-fill"></i><?php echo $_SESSION['msjExito'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjExito']);
    endif;

    if (isset($_SESSION['msjError'])) :
    ?>
        <div class="alert alert-danger alerta" role="alert">
            <strong><i class="bi bi-exclamation-triangle-fill"></i><?php echo $_SESSION['msjError'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjError']);
    endif;

    ?>


    <script src="../../js/validarRegistroHabitaciones.js"></script>
    <script>
        //* CONSULTA AJAX PARA FORMULARIO DEL REGISTRO DE HABITACIONES

        let tipoHab = $('#tipoHab');
        let inputAdd = $('#inputAgregado');

        tipoHab.on('change', function() {

            let seleccion = tipoHab.val();

            fetch(`../vistasAdmin/formTipoCama.php?id=${seleccion}`)
                .then(res => res.text())
                .then(datos => inputAdd.html(datos))
                .catch()

        });

        //* MOSTRAR DATOS DE SERVICIOS DE HABITACIONES PARA EDITAR

        $('.editServiciosBtn').click(function(e) {

            let elemento = e.target.parentElement.children;
            let arregloElemento = [...elemento];

            let datos = arregloElemento.map(function(element) {
                return $(element).text();
            });
            console.log(datos);

            $('#idServicio').val(datos[0]);
            $('#servicioAct').val(datos[2]);

        });

        $('.btnVolverHab').click(function() {

            location.reload();

        });
    </script>
</body>

</html>