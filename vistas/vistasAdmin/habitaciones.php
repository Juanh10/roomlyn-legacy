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

<head>
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <?php require_once "menuAdmin.php"; ?>
</head>

<body>

    <header class="cabeceraMenu">
        <div class="iconoMenu">
            <i class="bi bi-list btnIconoMenu" id="btnMenu2"></i>
            <span>HABITACIONES</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>

    <div class="contenido">
        <div class="container" id="contaionerHabitaciones">
            <div class="row">
                <div class="col">
                    <div class="btnBuscador">
                        <span class="btn" data-bs-toggle="modal" data-bs-target="#addHabitacion">Añadir habitación</span>
                    </div>
                    <div class="table-responsive tabla-usuarios">
                        <table class="table table-borderless text-center" id="tablaHabitaciones">
                            <thead class="tabla-background">
                                <tr>
                                    <th>Habitación</th>
                                    <th>Tipo habitación</th>
                                    <th>Sistema de climatización</th>
                                    <th>Camas</th>
                                    <th class="col-3">Observaciones</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($dbh->query($sql2) as $rowHab) :
                                ?>
                                    <tr>
                                        <td><?php echo $rowHab['nHabitacion'] ?></td>
                                        <td><?php echo $rowHab['tipoHabitacion'] ?></td>
                                        <td style="width: 100px;">
                                            <?php
                                            $sqlServicio = "SELECT habitaciones.id_servicio, habitaciones_servicios.servicio FROM habitaciones INNER JOIN habitaciones_servicios ON habitaciones_servicios.id_servicio = habitaciones.id_servicio WHERE habitaciones.id_servicio = " . $rowHab['id_servicio'] . "";
                                            $resultServ = $dbh->query($sqlServicio)->fetch();
                                            echo $resultServ['servicio'];
                                            ?>
                                        </td>
                                        <td><?php echo $rowHab['tipoCama'] ?></td>
                                        <td><?php echo $rowHab['observacion'] ?></td>
                                        <td><?php echo $rowHab['estado_habitacion'] ?></td>
                                        <td class="botones-Config" id="<?php echo $rowHab['id_habitacion'] ?>">
                                            <span class="bi bi-pencil-square btn btn-warning btn-sm botonEditar btnEditHab" data-bs-toggle="modal" data-bs-target="#editarHabitacion" title="Editar habitación"></span>
                                            <form action="../../procesos/registroHabitaciones/registroHabi/conDeshabilitarHabitaciones.php" method="post" class="desHabitacion">
                                                <input type="hidden" name="idHab" value="<?php echo $rowHab['id_habitacion'] ?>">
                                                <button type="submit" name="elmHab" class="btn btn-danger btn-sm eliminarbtn" title="Deshabilitar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" id="contaionerEditHabitaciones">

        </div>
    </div>


    <!-- MODAL DE AÑADIR HABITACION -->

    <div class="modal fade" id="addHabitacion" tabindex="-1" aria-labelledby="modalAñadir" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir habitación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7 me-5">
                                <form action="../../procesos/registroHabitaciones/registroHabi/conRegistroHabitaciones.php" method="post" id="formRegHab">

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
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" value="Añadir" name="añadirHab" class="boton-guardar">
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- MODAL DE AÑADIR MAS SERVICIOS -->

    <div class="modal fade" id="modalRegServ" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar elemento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="../../procesos/registroHabitaciones/registroServicios/conRegistroServicios.php" method="post">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nameServicio" name="elemento" placeholder="Servicio" required>
                            <label for="nameServicio">Elemento</label>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" value="Registrar" name="registrarElemento" class="btn boton-guardar">
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PARA ACTUALIZAR SERVICIOS -->

    <div class="modal fade" id="actualizarServicios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar elemento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../procesos/registroHabitaciones/registroServicios/conActualizarServicios.php" method="post">
                        <input type="hidden" class="form-control mt-2" id="idServicio" name="idServicio">
                        <label for="servicioAct">Elemento</label>
                        <input type="text" class="form-control mt-2" id="servicioAct" name="servicioAct">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" value="Actualizar" class="btn boton-guardar">
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- PIE DE PAGINA -->
    <footer class="pie-de-pagina">
        <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
    </footer>

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



</body>

</html>