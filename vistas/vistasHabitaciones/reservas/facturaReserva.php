<?php

include_once "../../../procesos/config/conex.php";

$fechasRango = $_GET['fechasRango'];
$tipoHab = $_GET['tipoHab'];
$habitacion = $_GET['habitacion'];

$sqlHabitacion = "SELECT id_habitacion, id_servicio, id_hab_estado, id_hab_tipo, nHabitacion, tipoCama, cantidadPersonasHab, observacion, estado FROM habitaciones WHERE id_habitacion = " . $habitacion . " AND estado = 1";

$rowHabitacion = $dbh->query($sqlHabitacion)->fetch();

$servHabitacion = $rowHabitacion['id_servicio'];

$sqlPrecioVentilador = "SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON hts.id_tipo_servicio = htp.id_tipo_servicio WHERE hts.id_hab_tipo = ".$tipoHab." AND hts.id_servicio = ".$servHabitacion." AND htp.estado = 1 AND hts.estado = 1";

$sqlPrecioAire = "SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON hts.id_tipo_servicio = htp.id_tipo_servicio WHERE hts.id_hab_tipo = ".$tipoHab." AND hts.id_servicio = ".$servHabitacion." AND htp.estado = 1 AND hts.estado = 1";

$rowPrecioVentilador = $dbh->query($sqlPrecioVentilador)->fetch();
$rowPrecioAire = $dbh->query($sqlPrecioAire)->fetch();

$arrayFechas = explode(" - ", $fechasRango);

$checkin = $arrayFechas[0];

$checkin = str_replace("/", "-", $checkin); // Reemplazamos "/" por "-"

$checkout = $arrayFechas[1];

$checkout = str_replace("/", "-", $checkout); // Reemplazamos "/" por "-"

// CONVERTIR FECHAS EN DIAS
$timestampInicio = strtotime($checkin);
$timestampFin = strtotime($checkout);

// Calcular la diferencia en segundos
$diferenciaSegundos = $timestampFin - $timestampInicio;

// Convertir la diferencia en segundos a días
$diferenciaDias = $diferenciaSegundos / 86400;

$diferenciaDias = round($diferenciaDias);

$total = 0;

if ($rowHabitacion['id_servicio'] == 1) {

    $precioTipo = $rowPrecioVentilador['precio'];

    $subtotal1 = $precioTipo * $diferenciaDias;

    $iva = $subtotal1 * 0.19;

    $totalFactura = $subtotal1 + $iva;
} else {
    $precioTipo = $rowPrecioAire['precio'];

    $subtotal1 = $precioTipo * $diferenciaDias;

    $iva = $subtotal1 * 0.19;

    $totalFactura = $subtotal1 + $iva;
}

?>

<div class="facturaReserva">
    <div class="totalReserva">
        <span class="precioTotal"><?php echo number_format($totalFactura, 0, ',', '.')  ?> COP</span>
        <div class="fechaHospedaje">
            <p><?php echo $checkin ?> | <?php echo $checkout ?></p>
            <p><?php echo $diferenciaDias ?> días</p>
        </div>
    </div>
    <div class="detallesFactura">
        <div class="btnAbrirDetalles">
            <span class="btnAbrirDet">Detalles de la reserva <i class="bi bi-caret-up-fill flechaDetalles"></i></span>
        </div>
        <div class="inforDetalles">
            <div class="fechasCheck">
                <p>Entrada: <?php echo $checkin ?></p>
                <p>Salida: <?php echo $checkout ?></p>
            </div>
            <div class="inforHab">
                <p>
                    <span>Habitación <?php echo $rowHabitacion['nHabitacion'] ?> | <?php echo $diferenciaDias ?> días</span>
                    <span><?php echo number_format($subtotal1, 0, ',', '.') ?></span>
                </p>
                <p>
                    <span>IVA </span>
                    <span><?php echo number_format($iva, 0, ',', '.')  ?></span>
                </p>
            </div>
            <div class="totalFactura">
                <p>
                    <span>TOTAL </span>
                    <span><?php echo number_format($totalFactura, 0, ',', '.')  ?> COP</span>
                </p>
                <div class="alert alert-success msjAlert" role="alert">
                    Para confirmar su reserva, se requiere un pago inicial del 50% antes de la fecha de llegada. Comuníquese al <a href="https://wa.link/ys192u" target="_blank">3156676013</a> para más detalles.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        $('.btnAbrirDetalles').click(function () {
        let detalles = $(this).next('.inforDetalles');
        if (detalles.is(':visible')) {
            $('.flechaDetalles').addClass('active');
            detalles.hide();
        } else {
            $('.flechaDetalles').removeClass('active');

            detalles.show();
        }
    })
</script>