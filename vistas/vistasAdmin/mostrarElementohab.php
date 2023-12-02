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
        <form id="formAñadirServicio">
            <input type="hidden" value="<?php echo $idTipoHab ?>" name="idTipoHab">
            <fieldset>
                <legend>Selecciona una opción</legend>

                <?php
                // Verificar si hay resultados antes de usar $row
                if ($stmt->rowCount() > 0) {
                    foreach ($stmt as $row) :
                ?>

                        <div class="listServicios">
                            <input type="checkbox" value="<?php echo $row['id_hab_elemento'] ?>" name="listaServi[]" id="<?php echo $row['id_hab_elemento'] ?>">
                            <label for="<?php echo $row['id_hab_elemento'] ?>"><?php echo $row['elemento'] ?></label>
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

    <!-- Script para manejar la solicitud AJAX -->
    <script>
        // Manejar el envío del formulario mediante AJAX
        $("#formAñadirServicio").submit(function(e) {
            e.preventDefault(); // Evitar el envío normal del formulario

            let formData = $(this).serializeArray();
            formData.push({
                name: 'añadirServ',
                value: true
            });

            // Realizar la solicitud AJAX
            $.ajax({
                type: "POST",
                url: "../../procesos/registroHabitaciones/registroHabi/conElementosHab.php",
                data: formData,
                success: function(response) {
                    // Verificar si la respuesta es un mensaje de error
                    if (response.indexOf("Debes seleccionar") !== -1 || response.indexOf("Ha habido un error") !== -1) {
                        // Mostrar el mensaje de error debajo de la lista
                        $(".elementosHabitacion").append('<div class="mensajeError">' + response + '</div>');
                    } else {
                        // Actualizar la sección de servicios con la nueva lista
                        $(".elementosHabitacion").html(response);
                    }
                    $('#modalAddServ3').modal('hide');
                },
                error: function() {
                    alert("Error al enviar la solicitud AJAX");
                }
            });
        });
    </script>

</body>

</html>