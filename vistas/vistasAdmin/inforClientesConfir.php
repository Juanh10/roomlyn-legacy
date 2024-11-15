<?php

include_once "../../procesos/config/conex.php";
include_once "../../procesos/funciones/formatearFechas.php";

$idHab = $_GET['id'];

$sql = "SELECT res.id_reserva, res.id_cliente, res.id_habitacion, res.id_estado_reserva, res.fecha_ingreso, res.fecha_salida, res.total_reserva, res.monto_abonado, res.saldo_pendiente, res.estado, info.nombres, info.apellidos, info.documento, info.celular FROM reservas AS res INNER JOIN info_clientes AS info ON info.id_info_cliente = res.id_cliente WHERE res.id_habitacion = " . $idHab . " AND res.id_estado_reserva = 2";

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
                <h1 class="fs-3 text-center mb-3">Información del cliente</h1>

                <p>Nombre: <?php echo $resultado['nombres'] . " " . $resultado['apellidos'] ?></p>
                <p>Documento: <?php echo $resultado['documento'] ?></p>
                <p>Celular: <?php echo $resultado['celular'] ?></p>
                <p>Fecha de ingreso: <?php echo formatearFecha($resultado['fecha_ingreso']) ?></p>
                <p>Fecha de salida: <?php echo formatearFecha($resultado['fecha_salida']) ?></p>
                <p>Total Reserva: <?php echo number_format($resultado['total_reserva'], 0, ',', '.') ?></p>
                <p>Monto abonado: <?php echo number_format($resultado['monto_abonado'], 0, ',', '.') ?></p>
                <p>Saldo pendiente: <?php echo number_format($resultado['saldo_pendiente'], 0, ',', '.') ?></p>
            </div>

            <div class="btnEstado d-flex flex-row justify-content-center">
                <form action="../../procesos/registroReservas/conCheck.php" method="post" class="mx-2" id="formCancelarRes">
                    <input type="hidden" name="idHab" value="<?php echo $idHab ?>">
                    <input type="hidden" name="idRes" value="<?php echo $idRes ?>">
                    <input type="hidden" name="checkIn" value="checkIn">
                    <input type="submit" class="btn boton-guardar" name="checkIn" value="Registrar Llegada">
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