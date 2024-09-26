<?php

include_once "../../procesos/config/conex.php";
include_once "../../procesos/funciones/formatearFechas.php";
include_once "../../procesos/funciones/convertirFechasDias.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $codigo = $_GET['codigo'];
    $sqlHabitaciones = $dbh->prepare("SELECT hb.id_habitacion, hb.id_hab_tipo, hb.id_hab_estado, hbs.id_servicio, hb.nHabitacion, hb.tipoCama, hb.cantidadPersonasHab, hb.estado, hbt.tipoHabitacion, hbe.estado_habitacion, hbs.servicio FROM habitaciones AS hb INNER JOIN habitaciones_tipos AS hbt ON hbt.id_hab_tipo = hb.id_hab_tipo INNER JOIN habitaciones_estado AS hbe ON hbe.id_hab_estado = hb.id_hab_estado INNER JOIN habitaciones_servicios hbs ON hbs.id_servicio = hb.id_servicio INNER JOIN llaveros_nfc AS ll ON hb.id_codigo_nfc = ll.id_codigo_nfc WHERE hb.estado = 1 AND ll.codigo = :codigo ORDER BY hb.nHabitacion ASC");
    $sqlHabitaciones->bindParam(':codigo', $codigo);
    $sqlHabitaciones->execute();
    $resultado = $sqlHabitaciones->fetch(\PDO::FETCH_ASSOC);

    $idHab = $resultado['id_habitacion'];
    $idEstadoHab = $resultado['id_hab_estado'];
    $tipoHab = $resultado['id_hab_tipo'];
    $servHabitacion = $resultado['id_servicio'];

    if ($idEstadoHab == 4 || $idEstadoHab == 5 || $idEstadoHab == 6) {

        $sqlReserva = $dbh->prepare("SELECT res.id_reserva, res.id_cliente, res.id_habitacion, res.id_estado_reserva, res.fecha_ingreso, res.fecha_salida, res.total_reserva, res.estado, info.nombres, info.apellidos, info.documento, info.celular FROM reservas AS res INNER JOIN info_clientes AS info ON info.id_info_cliente = res.id_cliente WHERE res.id_habitacion = :idHab AND res.id_estado_reserva = 2");
        $sqlReserva->bindParam(':idHab', $idHab);
        $sqlReserva->execute();
        $resultadoReserva = $sqlReserva->fetch(\PDO::FETCH_ASSOC);

        $checkin = $resultadoReserva['fecha_ingreso'];
        $checkout = $resultadoReserva['fecha_salida'];

        $diferenciaDias = convertirDias($checkin, $checkout);

        $sqlPrecioHab = $dbh->prepare("SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON hts.id_tipo_servicio = htp.id_tipo_servicio WHERE hts.id_hab_tipo = :tipoHab AND hts.id_servicio = :servicioHab AND htp.estado = 1 AND hts.estado = 1");
        $sqlPrecioHab->bindParam(':tipoHab', $tipoHab);
        $sqlPrecioHab->bindParam(':servicioHab', $servHabitacion);
        $sqlPrecioHab->execute();
        $resultadoPrecioHab = $sqlPrecioHab->fetch(\PDO::FETCH_ASSOC);

        $precioHabitacion = $resultadoPrecioHab['precio'];

        $facturaReserva = facturaReserva($precioHabitacion, $diferenciaDias);
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Document</title>
</head>

<body>

    <div class="btnVolverFiltro ms-5">
        <span>
            < Volver
                </span>
    </div>

    <div class="card-nfc">
        <div class="card-nfc-informacion">
            <div class="card-nfc-numhab">
                <span><strong><?php echo $resultado['nHabitacion'] ?></strong></span>
                <span><i class="bi bi-cart4"></i></span>
            </div>
            <?php
            if ($idEstadoHab == 4 || $idEstadoHab == 5 || $idEstadoHab == 6):
            ?>
                <div class="card-nfc-datpers"> <!-- DATOS PERSONALES -->
                    <span><strong><?php echo $resultadoReserva['documento'] ?></strong></span>
                    <span><strong><?php echo $resultadoReserva['nombres'] . " " . $resultadoReserva['apellidos'] ?></strong></span>
                    <div class="card-nfc-factura">
                        <span>Estancia</span> <span><?php echo $diferenciaDias . ' ' . ($diferenciaDias > 1 ? "días" : "día"); ?></span>
                        <span>Habitación</span> <span><?php echo number_format($precioHabitacion, 0, ',', '.') ?></span>
                        <span>Subtotal</span> <span><?php echo number_format($facturaReserva['subtotal'], 0, ',', '.') ?></span>
                        <span>IVA</span> <span><?php echo number_format($facturaReserva['iva'], 0, ',', '.') ?></span>
                        <span><strong>TOTAL</strong></span> <span><strong><?php echo number_format($resultadoReserva['total_reserva'], 0, ',', '.') ?> COP</strong></span>
                    </div>
                    <div class="card-nfc-fechas">
                        <span><strong>Entrada: </strong><?php echo formatearFecha($resultadoReserva['fecha_ingreso']) ?></span>
                        <span><strong>Salida: </strong><?php echo formatearFecha($resultadoReserva['fecha_salida']) ?></span>
                    </div>
                </div>
            <?php
            else:
            ?>
                <div class="card-nfc-datpers"> <!-- DATOS HABITACION -->
                    <span>Tipo: <?php echo $resultado['tipoHabitacion'] ?></span>
                    <span>Servicio: <?php echo $resultado['servicio'] ?></span>
                    <span>Tipo de cama: <?php echo $resultado['tipoCama'] ?></span>
                </div>

            <?php
            endif;
            ?>
            <!--        <div class="card-nfc-boton">
                <button>Finalizar reservación</button>
            </div> -->
        </div>

</body>

<script>
    $('.btnVolverFiltro').click(function() {
        location.reload();
    });
</script>

</html>