<?php
$idTipoHab = isset($_POST['idTipoHab']) ? $_POST['idTipoHab'] : null;


include_once "../../procesos/config/conex.php";

// Consulta para obtener todos los servicios
$sql = "SELECT habitaciones_elementos.id_hab_elemento, habitaciones_elementos.elemento 
        FROM habitaciones_elementos LEFT JOIN habitaciones_elementos_selec ON habitaciones_elementos_selec.id_hab_elemento = habitaciones_elementos.id_hab_elemento AND habitaciones_elementos_selec.id_habitacion = :idTipoHab AND habitaciones_elementos_selec.estado = 1 WHERE habitaciones_elementos_selec.id_hab_elemento IS NULL";

// Preparar la consulta
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':idTipoHab', $idTipoHab, PDO::PARAM_INT);
$stmt->execute();

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
        <form action="../../procesos/registroHabitaciones/registroHabi/conElementosHab.php" method="post">
            <input type="hidden" value="<?php echo $idTipoHab ?>" name="idTipoHab">
            <fieldset>
                <legend>Selecciona una opción</legend>

                <?php
                // Verificar si hay resultados antes de usar $row
                if ($stmt->rowCount() > 0) {
                    foreach ($stmt as $row) :
                ?>

                        <div class="listServicios">
                            <input type="checkbox" value="<?php echo $row['id_hab_elemento'] ?>" name="listaServi[]" id="<?php echo $row['elemento'] ?>">
                            <label for="<?php echo $row['elemento'] ?>"><?php echo $row['elemento'] ?></label>
                        </div>

                <?php
                    endforeach;
                } else {
                    echo "No se encontraron elementos.";
                }
                ?>

            </fieldset>
            <div class="btnAñadirServicio">
                <input type="submit" value="Añadir" name="añadirServ">
            </div>
        </form>
    </div>

</body>

</html>
