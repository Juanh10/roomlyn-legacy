<?php
session_start();

if (empty($_SESSION['idUsuario'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

/* echo $_SESSION['idUsuario'];
echo $_SESSION['pNombre'];
echo $_SESSION['pApellido'];
echo $_SESSION['tipoUsuario']; */

include_once "../../procesos/config/conex.php";

$sql = "SELECT id, tipoHabitacion FROM habitaciones_tipos WHERE 1 AND estado = 1"; //consulta para el modal de añadir habitaciones

$sql2 = "SELECT habitaciones.id, habitaciones.nHabitacion, habitaciones_tipos.tipoHabitacion, habitaciones.tipoCama, habitaciones.cantidadPersonasHab, habitaciones.tipoServicio, habitaciones.observacion, habitaciones.estado, habitaciones_estado.estado FROM habitaciones INNER JOIN habitaciones_tipos ON habitaciones.id_tipo = habitaciones_tipos.id INNER JOIN habitaciones_estado ON habitaciones.id_hab_estado = habitaciones_estado.id WHERE 1 ORDER BY habitaciones.id"; // consulta para mostrar todos los datos relacionados con las habitacione.

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
        <div class="container">
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
                                    <th class="col-3">Observaciones</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($dbh->query($sql2) as $rowHab) :
                                    if($rowHab[7] == 1):
                                ?>
                                    <tr>
                                        <td><?php echo $rowHab['nHabitacion'] ?></td>
                                        <td><?php echo $rowHab['tipoHabitacion'] ?></td>
                                        <td><?php echo ($rowHab['tipoServicio'] == 0) ? "Ventilador" : "Aire acondicionado"; ?></td>
                                        <td><?php echo $rowHab['observacion'] ?></td>
                                        <td><?php echo $rowHab['estado'] ?></td>
                                        <td class="botones-Config" id="<?php echo $rowHab['id'] ?>">
                                            <span class="bi bi-pencil-square btn btn-warning btn-sm botonEditar btnEditHab" data-bs-toggle="modal" data-bs-target="#editarHab" title="Editar habitación"></span>
                                            <span class="bi bi-gear btn btn-secondary btn-sm btnCambEstado" id="<?php echo $rowHab['id'] ?>" data-bs-toggle="modal" data-bs-target="#cambiarEstado" title="Cambiar de estado"></span>
                                            <form action="../../procesos/registroHabitaciones/registroHabi/conDeshabilitarHabitaciones.php" method="post" class="desHabitacion">
                                                <input type="hidden" name="idHab" value="<?php echo $rowHab['id'] ?>">
                                                <button type="submit" name="elmHab" class="btn btn-danger btn-sm eliminarbtn" title="Deshabilitar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                endif;
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL DE AÑADIR HABITACION -->

    <div class="modal fade" id="addHabitacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir habitación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="../../procesos/registroHabitaciones/registroHabi/conRegistroHabitaciones.php" method="post" id="formRegHab">

                        <label for="numHabitacion">Número de la habitación</label>
                        <input type="number" class="form-control mt-2" min="0" name="numHabitacion" id="numHabitacion" required>
                        <p></p>

                        <label for="tipoHab" class="mt-2">Tipo de habitación</label>
                        <select class="form-select mt-2" name="tipoHab" id="tipoHab" required>
                            <option disabled selected value="">Escoja una opción</option>
                            <?php
                            foreach ($dbh->query($sql) as $row) :
                            ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['tipoHabitacion'] ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                        <p></p>


                        <div id="inputAgregado">
                        <?php
                            include "habitaciones/formTipoCama.php"; // incluimos para añadir los demas inputs segun el tipo de habitacion escogida
                        ?>
                        </div>

                        <label class="mt-2" for="serv">Seleccione el sistema de climatización</label>
                        <select class="form-select mt-2" name="sisClimatizacion" id="servicio">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="0">Ventilador</option>
                            <option value="1">Aire acondicionado</option>
                        </select>

                        <label for="observaciones" class="mt-2">Observaciones</label>
                        <textarea class="form-control mt-2" name="observaciones" id="observaciones" required></textarea>
                        <p></p>
                </div>
                <div class="formularioMensaje">
                    <p>¡Por favor rellene todos los campos!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" value="Añadir" name="añadirHab" class="btn boton-guardar">
                </div>
                </form>

            </div>
        </div>
    </div>


    <!-- MODAL PARA EDITAR LAS HABITACIONES -->
    <div class="modal fade" id="editarHab" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar habitación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalEditHab"></div>
            </div>
        </div>
    </div>


    <!-- MODAL PARA CAMBIAR EL ESTADO DE LA HABITACIÓN -->
    <div class="modal fade" id="cambiarEstado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm"">
            <div class=" modal-content">
            <div class="modal-header fondo-modal">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar estado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalCambEstado"></div>
        </div>
    </div>
    </div>


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