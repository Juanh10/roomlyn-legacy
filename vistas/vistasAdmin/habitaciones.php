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
            <span>GESTIONAR HABITACIONES</span>
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
                        <span class="btn btn-crear-habitacion">Añadir habitación</span>
                    </div>
                    <div class="table-responsive tabla-usuarios">
                        <table class="table table-borderless text-center tableAdmin" id="tablaHabitaciones" aria-label="Habitaciones">
                            <thead class="tabla-background">
                                <tr>
                                    <th>Habitación</th>
                                    <th>Tipo habitación</th>
                                    <th>Sistema de climatización</th>
                                    <th>Camas</th>
                                    <th class="col-2">Observaciones</th>
                                    <th>Estado</th>
                                    <th class="col-2 no-export">Acción</th>
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
                                            <span class="bi bi-pencil-square btn btn-warning btn-sm botonEditar btnEditHab" title="Editar habitación"></span>
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
        <div class="container" id="containerAddHabitaciones">

        </div>
        <div class="container" id="contaionerEditHabitaciones">

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
                    <input type="submit" name="btnActElemento" value="Actualizar" class="btn boton-guardar">
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


    <!-- PIE DE PAGINA -->
    <footer class="pie-de-pagina">
        <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
    </footer>

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


</body>

</html>