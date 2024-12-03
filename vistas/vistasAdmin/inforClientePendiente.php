<?php

include_once "../../procesos/config/conex.php";
include_once "../../procesos/funciones/formatearFechas.php";

$idHab = $_GET['id'];

$sql = "SELECT res.id_reserva, res.id_cliente, res.id_habitacion, res.id_estado_reserva, res.fecha_ingreso, res.fecha_salida, res.total_reserva, res.monto_abonado, res.saldo_pendiente, res.estado, info.nombres, info.apellidos, info.documento, info.celular FROM reservas AS res INNER JOIN info_clientes AS info ON info.id_info_cliente = res.id_cliente WHERE res.id_habitacion = " . $idHab . " AND res.id_estado_reserva = 1";

$resultado = $dbh->query($sql)->fetch(PDO::FETCH_ASSOC);

$idRes = $resultado['id_reserva'];

?>

<!DOCTYPE html>

<body>

    <main class="container">

        <?php

        if ($resultado != false) :
        ?>
            <div class="informacionCliente">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h6 class="text-center fw-bold">Datos del Cliente</h6>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Nombre</th>
                                    <td><?php echo $resultado['nombres'] . " " . $resultado['apellidos']; ?></td>
                                </tr>
                                <tr>
                                    <th>Documento</th>
                                    <td><?php echo $resultado['documento']; ?></td>
                                </tr>
                                <tr>
                                    <th>Celular</th>
                                    <td><?php echo $resultado['celular']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <h6 class="text-center fw-bold">Detalles de la Reserva</h6>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Fecha de Ingreso</th>
                                    <td><?php echo formatearFecha($resultado['fecha_ingreso']); ?></td>
                                </tr>
                                <tr>
                                    <th>Fecha de Salida</th>
                                    <td><?php echo formatearFecha($resultado['fecha_salida']); ?></td>
                                </tr>
                                <tr>
                                    <th>Total Reserva</th>
                                    <td class="text-danger fw-bold"><?php echo number_format($resultado['total_reserva'], 0, ',', '.'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="btnEstado d-flex flex-row justify-content-center align-items-center gap-3 position-relative">
                <form class="mt-5 mx-2" action="../../procesos/registroReservas/conCancelarResAdmin.php" method="post" id="formCancelarRes">
                    <input type="hidden" name="idHab" value="<?php echo $idHab ?>">
                    <input type="hidden" name="idRes" value="<?php echo $idRes ?>">
                    <input type="hidden" name="cancelReserva" value="cancelReserva">
                    <input type="submit" class="btn btn-danger" name="cancelReserva" value="Cancelar reserva">
                </form>

                <form class="mt-5 mx-2" action="../../procesos/registroReservas/conCancelarResAdmin.php" method="post" id="formConfirmRes">
                    <input type="hidden" name="idHab" value="<?php echo $idHab ?>">
                    <input type="hidden" name="idRes" value="<?php echo $idRes ?>">

                    <input type="number" class="position-absolute top-0 start-0 form-control w-100" pattern="^[0-9]+$" id="montoReserva" name="montoReserva" min="0" placeholder="Cantidad a abonar" required>

                    <input type="hidden" name="confirmReserva" value="confirmReserva">
                    <input type="submit" class="btn btn-success" name="confirmReserva" value="Confirmar reserva">
                </form>
            </div>


        <?php

        else :
        ?>
            <span>No se encontraron registros</span>
        <?php
        endif;

        ?>
    </main>

    <script src="../../js/scriptSelectRecepcion.js"></script>

</body>

</html>