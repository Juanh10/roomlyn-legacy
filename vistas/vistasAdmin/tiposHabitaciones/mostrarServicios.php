<?php
$idTipoHab = $_GET['id'];

include_once "../../../procesos/config/conex.php";

// consulta para obtener todos los servicios
$sql = "SELECT habitaciones_servicios.id_servicio, habitaciones_servicios.servicio FROM habitaciones_servicios LEFT JOIN habitaciones_tipos_servicios ON habitaciones_tipos_servicios.id_servicio = habitaciones_servicios.id_servicio AND habitaciones_tipos_servicios.id_hab_tipo = ".$idTipoHab." AND habitaciones_tipos_servicios.estado = 1 WHERE habitaciones_tipos_servicios.id_servicio IS NULL";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
</head>

<body>

    <div class="contenServicios">
        <form action="../../procesos/registroHabitaciones/registroTipos/conActualizarTipo.php" method="post">
            <input type="hidden" value="<?php echo $idTipoHab ?>" name="idTipoHab">
            <fieldset>
                <legend>Selecciona una opción</legend>

                <?php

                foreach ($dbh->query($sql) as $row) :
                ?>

                    <div class="listServicios">
                        <input type="checkbox" value="<?php echo $row['id_servicio'] ?>" name="listaServi[]" id="<?php echo $row['servicio'] ?>">
                        <label for="<?php echo $row['servicio'] ?>"><?php echo $row['servicio'] ?></label>
                    </div>

                <?php
                endforeach;

                ?>

            </fieldset>
            <div class="btnAñadirServicio">
                <input type="submit" value="Añadir" name="añadirServ">
            </div>
        </form>
    </div>

</body>

</html>