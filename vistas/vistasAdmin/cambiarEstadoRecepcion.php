<?php

include_once "../../procesos/config/conex.php";
$idHab = $_GET['id'];
$archivo = $_GET['archivo'];

$sql = "SELECT habitaciones.id_habitacion, habitaciones.nHabitacion, habitaciones.id_hab_estado, habitaciones_estado.estado_habitacion FROM habitaciones INNER JOIN habitaciones_estado ON habitaciones.id_hab_estado = habitaciones_estado.id_hab_estado WHERE habitaciones.id_habitacion = " . $idHab . ""; // consulta del estado actual de la habitacion

$sql2 = "SELECT id_hab_estado, estado_habitacion FROM habitaciones_estado WHERE 1"; // consulta de los tipos de estado

?>

<!DOCTYPE html>

<body>

    <section class="formCambiarEstado ms-2">

        <h1 class="fs-6 mb-2">Estado de la habitación</h1>

        <form action="../../procesos/registroHabitaciones/registroHabi/conActualizarHabitaciones.php" method="post">
            <input type="hidden" name="idHab" value="<?php echo $idHab ?>">
            <input type="hidden" name="archivo" value="<?php echo $archivo ?>">
            <?php
            foreach ($dbh->query($sql) as $row1) :
            ?>
                <div class="form-check mb-2">
                    <input type="radio" class="form-check-input" value="<?php echo $row1['id_hab_estado'] ?>" name="opcion" id="opc1" checked>
                    <label for="opc1" class="form-check-label"><?php echo $row1['estado_habitacion'] ?></label>
                </div>
                <?php

                foreach ($dbh->query($sql2) as $row2) :
                    if ($row1['id_hab_estado'] != $row2['id_hab_estado'] && $row2['id_hab_estado'] != 4 && $row2['id_hab_estado'] != 5  && $row2['id_hab_estado'] != 6) :
                ?>
                        <div class="form-check mb-2">
                            <input type="radio" class="form-check-input" value="<?php echo $row2['id_hab_estado'] ?>" name="opcion" id="<?php echo $row2['estado_habitacion'] ?>">
                            <label for="<?php echo $row2['estado_habitacion'] ?>" class="form-check-label"><?php echo $row2['estado_habitacion'] ?></label>
                        </div>
            <?php
                    endif;
                endforeach;
            endforeach;
            ?>
            <input type="submit" name="actualizarEstado" value="Guardar" class="botonActualizar">
        </form>
    </section>

</body>

</html>