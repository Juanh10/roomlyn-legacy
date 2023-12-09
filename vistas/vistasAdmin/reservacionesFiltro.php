<?php

include_once "../../procesos/config/conex.php";

$fechaInicio = $_POST['fechaInicial'];
$fechaFin = $_POST['fechaFinal'];
$estado = $_POST['estado'];

$sqlReservas = "SELECT r.id_reserva, r.id_cliente, r.id_habitacion, r.id_estado_reserva, r.fecha_ingreso, r.fecha_salida, r.total_reserva, r.estado, DATE(r.fecha_sys) AS fecha_sys, info.nombres, info.apellidos, info.documento, es.nombre_estado, h.nHabitacion FROM reservas AS r INNER JOIN estado_reservas AS es ON es.id_estado_reserva = r.id_estado_reserva INNER JOIN habitaciones AS h ON h.id_habitacion = r.id_habitacion INNER JOIN info_clientes AS info ON info.id_info_cliente = r.id_cliente WHERE DATE(r.fecha_sys) BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ORDER BY r.id_reserva ASC";

$sqlTotal = "SELECT SUM(total_reserva) AS ingresos_totales FROM reservas WHERE id_estado_reserva = 4 AND fecha_ingreso BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "'";
$resultTotal = $dbh->query($sqlTotal)->fetch();

$sqlReservas2 = $dbh->prepare("SELECT r.id_reserva, r.id_cliente, r.id_habitacion, r.id_estado_reserva, r.fecha_ingreso, r.fecha_salida, r.total_reserva, r.estado,DATE(r.fecha_sys) AS fecha_sys, info.nombres, info.apellidos, info.documento, es.nombre_estado, h.nHabitacion FROM reservas AS r INNER JOIN estado_reservas AS es ON es.id_estado_reserva = r.id_estado_reserva INNER JOIN habitaciones AS h ON h.id_habitacion = r.id_habitacion INNER JOIN info_clientes AS info ON info.id_info_cliente = r.id_cliente WHERE r.id_estado_reserva = :estado AND DATE(r.fecha_sys) BETWEEN :fechaInicio AND :fechaFin ORDER BY r.id_reserva ASC");

$sqlEstados = "SELECT er.nombre_estado, COUNT(*) AS cantidad_reservas FROM reservas r JOIN estado_reservas er ON r.id_estado_reserva = er.id_estado_reserva WHERE DATE(r.fecha_sys) BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' GROUP BY r.id_estado_reserva";

$sqlEstados2 = $dbh->prepare("SELECT er.nombre_estado, COUNT(*) AS cantidad_reservas FROM reservas r JOIN estado_reservas er ON r.id_estado_reserva = er.id_estado_reserva WHERE r.id_estado_reserva = :estado AND DATE(r.fecha_sys) BETWEEN :fechaInicio AND :fechaFin");

?>

<div class="btnVolverFiltro mx-4">
    <span>
        < Volver</span>
</div>

<?php
if ($estado == 0) :
?>
    <div class="container" style="display: block;">
        <div class="row">
            <div class="mb-3">
                <div class="row">
                    <span class="desplegarInformacionRecep">Mostrar información</span>

                    <div class="col-md-3 mb-3">
                        <div class="card cardInformacion tarjeta">
                            <h4 style="text-align: center; margin: 8px;" class="numero-cant">$<?php echo number_format($resultTotal['ingresos_totales'], 0, ',', '.') ?></h4>
                            <p style="font-size: 12px; text-align: center;">Ingresos totales</p>
                        </div>
                    </div>

                    <?php

                    foreach ($dbh->query($sqlEstados) as $rowEstado) :
                    ?>
                        <div class="col-md-3 mb-3">
                            <div class="card cardInformacion tarjeta">
                                <h4 style="text-align: center; margin: 8px;"><?php echo $rowEstado['cantidad_reservas'] ?></h4>
                                <p style="font-size: 12px; text-align: center;">Reservas <?php echo $rowEstado['nombre_estado'] ?></p>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
            <div class="col">
                <div class="table-responsive tabla-reservas">
                    <table class="table table-hover table-borderless text-center" id="tablaReservasFiltro">
                        <thead class="tabla-background">
                            <tr>
                                <th>#</th>
                                <th>Habitación</th>
                                <th>Cliente</th>
                                <th>Documento</th>
                                <th>Fecha ingreso</th>
                                <th>Fecha salida</th>
                                <th>Estado</th>
                                <th>Total</th>
                                <th>Fecha registro</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($dbh->query($sqlReservas) as $row) :

                                $id = $row['id_reserva'];
                                $idHab = $row['id_habitacion'];
                                $habitacion = $row['nHabitacion'];
                                $idCliente = $row['id_cliente'];
                                $nombres = $row['nombres'];
                                $documento = $row['documento'];
                                $apellidos = $row['apellidos'];
                                $fechaIngreso = $row['fecha_ingreso'];
                                $fechaSalida = $row['fecha_salida'];
                                $idEstado = $row['id_estado_reserva'];
                                $estado = $row['nombre_estado'];
                                $total = $row['total_reserva'];
                                $fechaSys = $row['fecha_sys'];
                            ?>
                                <tr class="filas filasUsuario">
                                    <td class="datos"><?php echo $id ?></td>
                                    <td class="datos"><?php echo $habitacion ?></td>
                                    <td class="datos"><?php echo $nombres . " " . $apellidos ?></td>
                                    <td class="datos"><?php echo $documento ?></td>
                                    <td class="datos"><?php echo $fechaIngreso ?></td>
                                    <td class="datos"><?php echo $fechaSalida ?></td>
                                    <td class="datos"><?php echo $estado ?></td>
                                    <td class="datos"><?php echo number_format($total, 0, ',', '.') ?></td>
                                    <td class="datos" style="color: #ec7171;"><?php echo $fechaSys ?></td>
                                    <td>
                                        <div class="accion">
                                            <span class="bi bi-search btn btn-primary btn-sm mx-2 btnInforCli" data-bs-toggle="modal" data-bs-target="#modalVerInformacion" title="Ver información del cliente" id="<?php echo $idCliente ?>"></span>
                                            <?php
                                            if ($idEstado == 1) :
                                            ?>
                                                <form action="../../procesos/registroReservas/conCancelarResAdmin.php" method="post" class="formularioEliminar">
                                                    <input type="hidden" name="idRes" value="<?php echo $id ?>">
                                                    <input type="hidden" name="idHab" value="<?php echo $idHab ?>">
                                                    <input type="hidden" name="cancelRes" value="cancelar">
                                                    <button type="submit" class="btn btn-danger btn-sm eliminarbtn" title="Cancelar reserva ">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            <?php
                                            endif;
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="paginacionTabla">
                    <div class="inforPaginacion">
                        <span id="totalRegistro"></span>
                        <span id="pagActual"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php

else :

    // EJECUTAR CONSULTAS
    $sqlReservas2->bindParam(':estado', $estado);
    $sqlReservas2->bindParam(':fechaInicio', $fechaInicio);
    $sqlReservas2->bindParam(':fechaFin', $fechaFin);
    $sqlReservas2->execute();
    $resultRes = $sqlReservas2->fetchAll(PDO::FETCH_ASSOC);

    $sqlEstados2->bindParam(':estado', $estado);
    $sqlEstados2->bindParam(':fechaInicio', $fechaInicio);
    $sqlEstados2->bindParam(':fechaFin', $fechaFin);
    $sqlEstados2->execute();
    $resultEstados = $sqlEstados2->fetchAll(PDO::FETCH_ASSOC);

?>
    <div class="container" id="contenedorIniReservaciones">
        <div class="row">
            <div class="container mb-3">
                <div class="row">
                    <span class="desplegarInformacionRecep">Mostrar información</span>
                    <?php
                    if ($estado == 4) :
                        $sqlTotal = "SELECT SUM(total_reserva) AS ingresos_totales FROM reservas WHERE id_estado_reserva = 4 AND fecha_ingreso BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "'";
                        $resultTotal = $dbh->query($sqlTotal)->fetch();
                    ?>
                        <div class="col-md-3 mb-3">
                            <div class="card cardInformacion tarjeta">
                                <h4 style="text-align: center; margin: 8px;" class="numero-cant">$<?php echo number_format($resultTotal['ingresos_totales'], 0, ',', '.') ?></h4>
                                <p style="font-size: 12px; text-align: center;">Ingresos totales</p>
                            </div>
                        </div>
                    <?php
                    endif;
                    ?>
                    <?php
                    foreach ($resultEstados as $rowEstado) :
                    ?>
                        <div class="col-md-3 mb-3">
                            <div class="card cardInformacion tarjeta">
                                <h4 style="text-align: center; margin: 8px;"><?php echo $rowEstado['cantidad_reservas'] ?></h4>
                                <p style="font-size: 12px; text-align: center;">
                                    <?php echo ($rowEstado['cantidad_reservas'] == 0) ? "Sin información" : "Reservas" . $rowEstado['nombre_estado']; ?>
                                </p>

                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
            <div class="col">
                <div class="table-responsive tabla-reservas">
                    <table class="table table-hover table-borderless text-center" id="tablaReservasFiltro">
                        <thead class="tabla-background">
                            <tr>
                                <th>#</th>
                                <th>Habitación</th>
                                <th>Cliente</th>
                                <th>Documento</th>
                                <th>Fecha ingreso</th>
                                <th>Fecha salida</th>
                                <th>Estado</th>
                                <th>Total</th>
                                <th>Fecha registro</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($resultRes as $row) :

                                $id = $row['id_reserva'];
                                $idHab = $row['id_habitacion'];
                                $habitacion = $row['nHabitacion'];
                                $idCliente = $row['id_cliente'];
                                $nombres = $row['nombres'];
                                $documento = $row['documento'];
                                $apellidos = $row['apellidos'];
                                $fechaIngreso = $row['fecha_ingreso'];
                                $fechaSalida = $row['fecha_salida'];
                                $idEstado = $row['id_estado_reserva'];
                                $estado = $row['nombre_estado'];
                                $total = $row['total_reserva'];
                                $fechaSys = $row['fecha_sys'];
                            ?>
                                <tr class="filas filasUsuario">
                                    <td class="datos"><?php echo $id ?></td>
                                    <td class="datos"><?php echo $habitacion ?></td>
                                    <td class="datos"><?php echo $nombres . " " . $apellidos ?></td>
                                    <td class="datos"><?php echo $documento ?></td>
                                    <td class="datos" style="color: #ec7171;"><?php echo $fechaIngreso ?></td>
                                    <td class="datos"><?php echo $fechaSalida ?></td>
                                    <td class="datos"><?php echo $estado ?></td>
                                    <td class="datos"><?php echo number_format($total, 0, ',', '.') ?></td>
                                    <td class="datos"><?php echo $fechaSys ?></td>
                                    <td>
                                        <div class="accion">
                                            <span class="bi bi-search btn btn-primary btn-sm mx-2 btnInforCli" data-bs-toggle="modal" data-bs-target="#modalVerInformacion" title="Ver información del cliente" id="<?php echo $idCliente ?>"></span>
                                            <?php
                                            if ($idEstado == 1) :
                                            ?>
                                                <form action="../../procesos/registroReservas/conCancelarResAdmin.php" method="post" class="formularioEliminar">
                                                    <input type="hidden" name="idRes" value="<?php echo $id ?>">
                                                    <input type="hidden" name="idHab" value="<?php echo $idHab ?>">
                                                    <input type="hidden" name="cancelRes" value="cancelar">
                                                    <button type="submit" class="btn btn-danger btn-sm eliminarbtn" title="Cancelar reserva ">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            <?php
                                            endif;
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="paginacionTabla">
                    <div class="inforPaginacion">
                        <span id="totalRegistro"></span>
                        <span id="pagActual"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
endif;
?>

<script src="../../js/scriptDataTablesFiltro.js"></script>
<script>
    $('.btnInforCli').click(function() {
        let idCLiente = $(this).attr('id');
        let contenido = $('#contenidoInforCliente');

        fetch(`../../vistas/vistasAdmin/inforCLienteReserva.php?id=${idCLiente}`)
            .then(res => res.text())
            .then(datos => contenido.html(datos))
            .catch();
    });

    $('.desplegarInformacionRecep').click(function() {
        $('.cardInformacion').toggle()
    });

    $('.btnVolverFiltro').click(function() {
        location.reload();
    });
</script>