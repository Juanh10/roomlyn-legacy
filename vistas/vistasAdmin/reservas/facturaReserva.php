<?php

include_once "../../../procesos/config/conex.php";
include_once "../../../procesos/funciones/formatearFechas.php";
include_once  "../../../procesos/funciones/convertirFechasDias.php";

$fechasRango = $_GET['fechasRango'];
$tipoHab = $_GET['tipoHab'];
$habitacion = $_GET['habitacion'];

$sqlHabitacion = "SELECT id_habitacion, id_servicio, id_hab_estado, id_hab_tipo, nHabitacion, tipoCama, cantidadPersonasHab, observacion, estado FROM habitaciones WHERE id_habitacion = " . $habitacion . " AND estado = 1";

$rowHabitacion = $dbh->query($sqlHabitacion)->fetch();

$servHabitacion = $rowHabitacion['id_servicio'];

$sqlPrecioVentilador = "SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON hts.id_tipo_servicio = htp.id_tipo_servicio WHERE hts.id_hab_tipo = " . $tipoHab . " AND hts.id_servicio = " . $servHabitacion . " AND htp.estado = 1 AND hts.estado = 1";

$sqlPrecioAire = "SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON hts.id_tipo_servicio = htp.id_tipo_servicio WHERE hts.id_hab_tipo = " . $tipoHab . " AND hts.id_servicio = " . $servHabitacion . " AND htp.estado = 1 AND hts.estado = 1";

$rowPrecioVentilador = $dbh->query($sqlPrecioVentilador)->fetch();
$rowPrecioAire = $dbh->query($sqlPrecioAire)->fetch();

$arrayFechas = explode(" - ", $fechasRango);

$checkin = $arrayFechas[0];

$checkin = str_replace("/", "-", $checkin); // Reemplazamos "/" por "-"

$checkout = $arrayFechas[1];

$checkout = str_replace("/", "-", $checkout); // Reemplazamos "/" por "-"

$diferenciaDias = convertirDias($checkin, $checkout);

$total = 0;

if ($rowHabitacion['id_servicio'] == 1) {

    $precioTipo = $rowPrecioVentilador['precio'];

    $subtotal1 = $precioTipo * $diferenciaDias;

    //$iva = $subtotal1 * 0.19;

    //$totalFactura = $subtotal1 + $iva;
    $totalFactura = $subtotal1;
} else {
    $precioTipo = $rowPrecioAire['precio'];

    $subtotal1 = $precioTipo * $diferenciaDias;

    //$iva = $subtotal1 * 0.19;

    //$totalFactura = $subtotal1 + $iva;
    $totalFactura = $subtotal1;
}

?>

<div class="facturaReserva" data-idHab="<?php echo $habitacion ?>" data-idTipoHab="<?php echo $tipoHab ?>">
    <div class="totalReserva">
        <span class="precioTotal"><?php echo number_format($totalFactura, 0, ',', '.')  ?> COP</span>
        <div class="fechaHospedaje" data-checkin = "<?php echo $checkin ?>" data-checkout="<?php echo $checkout ?>">
            <p><?php echo $checkin ?> | <?php echo $checkout ?></p>
            <p><?php echo $diferenciaDias.' '.($diferenciaDias > 1 ? 'días' : 'día') ?></p>
        </div>
    </div>
    <div class="detallesFactura">
        <div class="btnAbrirDetalles">
            <span class="btnAbrirDet">Detalles de la reserva <i class="bi bi-caret-up-fill flechaDetalles"></i></span>
        </div>
        <div class="inforDetalles">
            <div class="fechasCheck">
                <p>Entrada: <?php echo formatearFecha($checkin) ?></p>
                <p>Salida: <?php echo formatearFecha($checkout) ?></p>
            </div>
            <div class="inforHab">
                <div class="detToFac d-flex justify-content-between align-self-center mt-2">
                    <span class="detToFacNumHab">Habitación <?php echo $rowHabitacion['nHabitacion'] ?></span>
                    <div class="contenedorEdicionTotal d-flex">
                        <i class="bi bi-pencil-square" id="totalFacturaEdit" title="Editar valor"></i>
                        <span id="totalFacturaValor"><?php echo number_format($precioTipo, 0, ',', '.') ?></span>
                        <input type="hidden" value="<?php echo $precioTipo ?>" class="form-control w-50 inputEditValor" name="nuevoValor" id="nuevoValor">
                        <button id="guardarValor" style="display: none;"><i class="bi bi-check-lg"></i></button>
                    </div>
                </div>
                <div class="d-flex justify-content-between aling-self-center">
                    <span id="infoHabDias" data-dias="<?php echo $diferenciaDias ?>">Estancia: <?php echo $diferenciaDias . ' ' . ($diferenciaDias > 1 ? 'días' : 'día') ?></span>
                    <span id="infoHabDiasValor"><?php echo number_format($subtotal1, 0, ',', '.') ?></span>
                </div>
            </div>


            <div class="totalFactura d-flex justify-content-between py-2 fs-5 fw-bold">
                <span>TOTAL </span>
                <span id="totalFacturaFinal">
                    <?php echo number_format($totalFactura, 0, ',', '.')  ?> COP
                </span>
            </div>
        </div>
    </div>
</div>

<script src="../../js/scriptFacturas.js"></script>