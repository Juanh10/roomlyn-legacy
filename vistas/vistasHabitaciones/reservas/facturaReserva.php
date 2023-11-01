<?php

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
            <span class="btnAbrirDet">Detalles de la reserva <i class="bi bi-caret-down-fill flechaDetalles"></i></span>
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
                Para confirmar su reserva, se requiere un pago inicial del 50% antes de la fecha de llegada. Comuníquese al 318-654-7890 para más detalles.
                </div>
            </div>
        </div>
    </div>
</div>