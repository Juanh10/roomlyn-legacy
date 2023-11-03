<?php

include_once "../../../procesos/config/conex.php";

$fechasRango = $_GET['fechasRango'];
$tipoHab = $_GET['tipoHab'];
$habitacion = $_GET['habitacion'];

$sqlHabitacion = "SELECT id_habitaciones, id_hab_estado, id_hab_tipo, nHabitacion, tipoCama, cantidadPersonasHab, tipoServicio, observacion, estado FROM habitaciones WHERE id_habitaciones = " . $habitacion . " AND estado = 1";

$rowHabitacion = $dbh->query($sqlHabitacion)->fetch();

$sqlTipoHab = "SELECT id_hab_tipo, precioVentilador, precioAire, estado FROM habitaciones_tipos WHERE id_hab_tipo = " . $tipoHab . " AND estado = 1";

$rowTipoHab = $dbh->query($sqlTipoHab)->fetch();

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

if ($rowHabitacion['tipoServicio'] == 0) {

    $precioTipo = $rowTipoHab['precioVentilador'];

    $subtotal1 = $precioTipo * $diferenciaDias;

    $iva = $subtotal1 * 0.19;

    $totalFactura = $subtotal1 + $iva;
} else {
    $total = 4;
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
                    Para confirmar su reserva, se requiere un pago inicial del 50% antes de la fecha de llegada. Comuníquese al <a href="#">318-654-7890</a> para más detalles.
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