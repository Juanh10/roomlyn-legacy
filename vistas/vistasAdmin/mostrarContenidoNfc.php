<?php

include_once "../../procesos/config/conex.php";
include_once "../../procesos/funciones/formatearFechas.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $codigo = $_GET['codigo'];
    $sqlHabitaciones = $dbh->prepare("SELECT hb.id_habitacion, hb.id_hab_tipo, hb.id_hab_estado, hb.nHabitacion, hb.tipoCama, hb.cantidadPersonasHab, hb.estado, hbt.tipoHabitacion, hbe.estado_habitacion, hbs.servicio FROM habitaciones AS hb INNER JOIN habitaciones_tipos AS hbt ON hbt.id_hab_tipo = hb.id_hab_tipo INNER JOIN habitaciones_estado AS hbe ON hbe.id_hab_estado = hb.id_hab_estado INNER JOIN habitaciones_servicios hbs ON hbs.id_servicio = hb.id_servicio INNER JOIN llaveros_nfc AS ll ON hb.id_codigo_nfc = ll.id_codigo_nfc WHERE hb.estado = 1 AND ll.codigo = :codigo ORDER BY hb.nHabitacion ASC");
    $sqlHabitaciones->bindParam(':codigo', $codigo);
    $sqlHabitaciones->execute();
    $resultado = $sqlHabitaciones->fetch(\PDO::FETCH_ASSOC);

    $idHab = $resultado['id_habitacion'];

    $sqlReserva = $dbh->prepare("SELECT res.id_reserva, res.id_cliente, res.id_habitacion, res.id_estado_reserva, res.fecha_ingreso, res.fecha_salida, res.total_reserva, res.estado, info.nombres, info.apellidos, info.documento, info.celular FROM reservas AS res INNER JOIN info_clientes AS info ON info.id_info_cliente = res.id_cliente WHERE res.id_habitacion = :idHab AND res.id_estado_reserva = 2");
    $sqlReserva->bindParam(':idHab', $idHab);
    $sqlReserva->execute();
    $resultadoReserva = $sqlReserva->fetch(\PDO::FETCH_ASSOC);
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

    <div class="cardHabitaciones backCardHab">
        <div class="informacionHab">
            <div class="numHabitacion">
                <span><?php echo $resultado['nHabitacion'] ?></span>
            </div>
            <div class="inforHab">
                <span><?php echo $resultado['tipoHabitacion'] ?></span>
                <span><?php echo $resultado['servicio'] ?></span>
                <span><?php echo $resultado['tipoCama'] ?></span>
                <span><?php echo formatearFecha($resultadoReserva['fecha_ingreso']) ?></span>
                <span><?php echo formatearFecha($resultadoReserva['fecha_salida']) ?></span>
                <span><?php echo $resultadoReserva['total_reserva'] ?></span>
                <span><?php echo $resultadoReserva['documento'] ?></span>
                <span><?php echo $resultadoReserva['celular'] ?></span>
                <span><?php echo $resultadoReserva['nombres'] ?></span>
                <span><?php echo $resultadoReserva['apellidos'] ?></span>

            </div>
        </div>

</body>

<script>
    $('.btnVolverFiltro').click(function() {
        location.reload();
    });
</script>

</html>