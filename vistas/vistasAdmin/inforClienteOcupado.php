<?php

include_once "../../procesos/config/conex.php";
include_once "../../procesos/funciones/formatearFechas.php";

$idHab = $_GET['id'];

$sql = "SELECT res.id_reserva, res.id_cliente, res.id_habitacion, res.id_estado_reserva, res.fecha_ingreso, res.fecha_salida, res.total_reserva, res.monto_abonado, res.saldo_pendiente, res.estado, info.nombres, info.apellidos, info.documento, info.celular FROM reservas AS res INNER JOIN info_clientes AS info ON info.id_info_cliente = res.id_cliente WHERE res.id_habitacion = " . $idHab . " AND res.id_estado_reserva = 2";

$resultado = $dbh->query($sql)->fetch(PDO::FETCH_ASSOC);

$idRes = $resultado['id_reserva'];

$saldoPendienteRes = $resultado['saldo_pendiente'];

$sqlConsumo = $dbh->query("SELECT SUM(idv.precio_total) AS total_precio FROM inventario_detalles_ventas as idv INNER JOIN inventario_ventas as iv ON idv.id_venta = iv.id_venta INNER JOIN reservas as r ON iv.id_reserva = r.id_reserva WHERE iv.id_reserva = $idRes AND idv.estado_debe = 1")->fetch();

$totalConsumo = $sqlConsumo['total_precio'];

$totalFactura = $saldoPendienteRes + $totalConsumo;

?>

<!DOCTYPE html>

<body>

    <main class="container">

        <?php

        if ($resultado != false) :
        ?>
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

            <div class="row mb-4">
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
                                <td><?php echo number_format($resultado['total_reserva'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Monto Abonado</th>
                                <td><?php echo number_format($resultado['monto_abonado'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Saldo Pendiente</th>
                                <td><?php echo number_format($resultado['saldo_pendiente'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Consumo</th>
                                <td><?php echo number_format($totalConsumo, 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Total Factura</th>
                                <td class="fw-bold text-danger"><?php echo number_format($totalFactura, 0, ',', '.'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="btnEstado d-flex flex-row justify-content-center">
                <form action="../../procesos/registroReservas/conCheck.php" method="post" class="mx-2" id="formCancelarRes">
                    <input type="hidden" name="idHab" value="<?php echo $idHab ?>">
                    <input type="hidden" name="idRes" value="<?php echo $idRes ?>">
                    <input type="hidden" name="checkOut" value="checkOut">
                    <input type="submit" class="btn boton-guardar" name="checkOut" value="Registrar Salida">
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