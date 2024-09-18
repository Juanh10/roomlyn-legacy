<?php
include_once "../../procesos/config/conex.php";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $codigo = $_GET['codigo'];
    $sql = $dbh->prepare("SELECT hb.id_habitacion, hb.id_hab_tipo, hb.id_hab_estado, hb.nHabitacion, hb.tipoCama, hb.cantidadPersonasHab, hb.estado, hbt.tipoHabitacion, hbe.estado_habitacion, hbs.servicio, hbe.estado_habitacion FROM habitaciones AS hb INNER JOIN habitaciones_tipos AS hbt ON hbt.id_hab_tipo = hb.id_hab_tipo INNER JOIN habitaciones_estado AS hbe ON hbe.id_hab_estado = hb.id_hab_estado INNER JOIN habitaciones_servicios hbs ON hbs.id_servicio = hb.id_servicio INNER JOIN llaveros_nfc AS ll ON hb.id_codigo_nfc = ll.id_codigo_nfc WHERE hb.estado = 1 AND ll.codigo = :codigo ORDER BY hb.nHabitacion ASC");
    $sql->bindParam(':codigo', $codigo);
    $sql->execute();
    $resultado = $sql->fetch(\PDO::FETCH_ASSOC);
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
            </div>
        </div>

</body>

<script>
    $('.btnVolverFiltro').click(function() {
        location.reload();
    });
</script>

</html>