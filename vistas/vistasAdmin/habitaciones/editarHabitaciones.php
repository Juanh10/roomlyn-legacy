<?php

include_once "../../../procesos/config/conex.php";

$idHab = $_GET['id'];

$sql = "SELECT habitaciones.id, habitaciones.nHabitacion, habitaciones.id_tipo, habitaciones.id_hab_estado, habitaciones.observacion, habitaciones_estado.estado, habitaciones_tipos.tipoHabitacion FROM habitaciones INNER JOIN habitaciones_estado ON habitaciones.id_hab_estado = habitaciones_estado.id INNER JOIN habitaciones_tipos ON habitaciones.id_tipo = habitaciones_tipos.id WHERE habitaciones.id = " . $idHab . ""; // consulta sobre todos los datos de las habitaciones

$sql2 = "SELECT id, tipoHabitacion FROM habitaciones_tipos WHERE 1 AND estado = 1"; // consulta de los tipos de habitaciones

?>

<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <link rel="stylesheet" href="../../librerias/bootstrap5/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <div class="formEditHab">
            <form action="../../procesos/registroHabitaciones/registroHabi/conActualizarHabitaciones.php" method="post">
                <?php
                foreach ($dbh->query($sql) as $rowHab) : // mostrar datos
                ?>
                    <input type="hidden" name="idHab" value="<?php echo $idHab?>">
                    <label for="numHabitacion">Número de la habitación</label>
                    <input type="number" class="form-control mt-2" min="0" name="numHabitacion" id="numHabitacion" value="<?php echo $rowHab['nHabitacion'] ?>" required>

                    <label for="tipoHab" class="mt-2">Tipo de habitación</label>
                    <select class="form-select mt-2" name="tipoHab" id="tipoHab" required>
                        <option selected value="<?php echo $rowHab['id_tipo'] ?>"><?php echo $rowHab['tipoHabitacion'] ?></option>
                        <?php
                        foreach ($dbh->query($sql2) as $rowTipo) :
                            if ($rowHab['id_tipo'] != $rowTipo['id']) :
                        ?>
                                <option value="<?php echo $rowTipo['id'] ?>"><?php echo $rowTipo['tipoHabitacion'] ?></option>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </select>

                    <label for="observaciones" class="mt-2">Observaciones</label>
                    <textarea class="form-control mt-2" name="observaciones" id="observaciones" required><?php echo $rowHab['observacion'] ?></textarea>
                <?php
                endforeach;
                ?>
                <input type="submit" class="botonActualizar" name="btnActualizar" value="Actualizar">
            </form>
        </div>
    </div>

</body>

</html>