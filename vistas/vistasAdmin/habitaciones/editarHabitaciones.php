<?php

include_once "../../../procesos/config/conex.php";

$idHab = $_GET['id'];

$sql = "SELECT habitaciones.id_habitaciones, habitaciones.nHabitacion, habitaciones.id_hab_tipo, habitaciones.tipoCama, habitaciones.id_hab_estado, habitaciones.tipoServicio, habitaciones.observacion, habitaciones_estado.estado_habitacion, habitaciones_tipos.tipoHabitacion FROM habitaciones INNER JOIN habitaciones_estado ON habitaciones.id_hab_estado = habitaciones_estado.id_hab_estado INNER JOIN habitaciones_tipos ON habitaciones.id_hab_tipo = habitaciones_tipos.id_hab_tipo WHERE habitaciones.id_habitaciones = " . $idHab . ""; // consulta sobre todos los datos de las habitaciones

$sql2 = "SELECT id_hab_tipo, tipoHabitacion FROM habitaciones_tipos WHERE 1 AND estado = 1"; // consulta de los tipos de habitaciones

?>

<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <link rel="stylesheet" href="../../librerias/bootstrap5/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <div class="formEditHab">
            <form action="../../procesos/registroHabitaciones/registroHabi/conActualizarHabitaciones.php" method="post" id="formRegHab">
                <?php
                foreach ($dbh->query($sql) as $rowHab) : // mostrar datos
                ?>
                    <input type="hidden" name="idHab" value="<?php echo $idHab ?>">
                    <label for="numHabitacion">Número de la habitación</label>
                    <input type="number" class="form-control mt-2" min="0" name="numHabitacion" id="numHabitacion" value="<?php echo $rowHab['nHabitacion'] ?>" required>

                    <label for="tipoHabEdit" class="mt-2">Tipo de habitación</label>
                    <select class="form-select mt-2 mb-3" name="tipoHab" id="tipoHabEdit" required>
                        <option selected value="<?php echo $rowHab['id_hab_tipo'] ?>"><?php echo $rowHab['tipoHabitacion'] ?></option>
                        <?php
                        foreach ($dbh->query($sql2) as $rowTipo) :
                            if ($rowHab['id_hab_tipo'] != $rowTipo['id_hab_tipo']) :
                        ?>
                                <option value="<?php echo $rowTipo['id_hab_tipo'] ?>"><?php echo $rowTipo['tipoHabitacion'] ?></option>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </select>

                    <div id="addSelect">
                        <?php
                        include "editTipoCama.php";
                        ?>
                    </div>

                    <label class="mt-2" for="serv">Sistema de climatización</label>
                    <select class="form-select mt-2" name="sisClimatizacion" id="servicio">
                        <?php
                        if ($rowHab['tipoServicio'] == 0) :
                        ?>
                            <option value="0" selected>Ventilador</option>
                            <option value="1">Aire acondicionado</option>
                        <?php
                        else :
                        ?>
                            <option value="1" selected>Aire acondicionado</option>
                            <option value="0">Ventilador</option>
                        <?php
                        endif;
                        ?>
                    </select>

                    <label for="observaciones" class="mt-2">Observaciones</label>
                    <textarea class="form-control mt-2 mb-3" name="observaciones" id="observaciones" required><?php echo $rowHab['observacion'] ?></textarea>
                <?php
                endforeach;
                ?>
                <input type="submit" class="botonActualizar" name="btnActualizar" value="Actualizar">
            </form>
        </div>
    </div>


    <script src="../../librerias/jquery-3.7.0.min.js"></script>
    <script src="../../js/scriptModalAdmit.js"></script>

</body>

</html>