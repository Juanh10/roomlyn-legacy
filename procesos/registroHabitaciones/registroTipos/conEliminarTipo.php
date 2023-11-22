<?php

session_start();

include_once "../../config/conex.php";

// Variable que indica si la operación fue exitosa
$exito = false;

// Verificar si se recibió el parámetro 'idTipoHab' en la solicitud POST
if (!empty($_POST['idTipoHab'])) {

    // Obtener el valor de 'idTipoHab' desde la solicitud POST
    $idTipo = $_POST['idTipoHab'];

    // Establecer el valor del estado a 0
    $estado = 0;

    // Preparar las consultas SQL para actualizar diferentes tablas
    $sql = $dbh->prepare("UPDATE habitaciones_tipos SET estado=:estado WHERE id_hab_tipo = :idTipo");
    $sql2 = $dbh->prepare("UPDATE habitaciones SET estado=:estado WHERE id_hab_tipo = :idTipo");
    $sqlServicios = $dbh->prepare("UPDATE habitaciones_tipos_servicios SET estado = :estado WHERE id_hab_tipo = :idTipo");
    $sqlPrecios = $dbh->prepare("UPDATE habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON hts.id_tipo_servicio = htp.id_tipo_servicio SET htp.estado = :estado WHERE hts.id_hab_tipo = :idTipo");
    $sqlImg = $dbh->prepare("UPDATE habitaciones_imagenes SET estado = :estado WHERE id_hab_tipo = :idTipo");

    // Asociar los parámetros con los valores correspondientes en las consultas
    $sql->bindParam(':estado', $estado);
    $sql->bindParam(':idTipo', $idTipo);

    // Ejecutar la primera consulta y procede si es exitosa
    if ($sql->execute()) {

        $sql2->bindParam(':estado', $estado);
        $sql2->bindParam(':idTipo', $idTipo);

        if ($sql2->execute()) {

            $sqlServicios->bindParam(':estado', $estado);
            $sqlServicios->bindParam(':idTipo', $idTipo);

            if ($sqlServicios->execute()) {

                $sqlPrecios->bindParam(':estado', $estado);
                $sqlPrecios->bindParam(':idTipo', $idTipo);

                if ($sqlPrecios->execute()) {
                    $sqlImg->bindParam(':estado', $estado);
                    $sqlImg->bindParam(':idTipo', $idTipo);

                    // Ejecutar la quinta consulta y marcar como exitoso si es exitosa
                    if ($sqlImg->execute()) {
                        $exito = true;
                    }
                }
            }
        }
    }
}

// Verificar si la operación fue exitosa y configura mensajes de sesión correspondientes
if ($exito) {
    $_SESSION['msjExito'] = "¡Se ha deshabilitado correctamente!";
} else {
    $_SESSION['msjError'] = "Ocurrió un error";
}

// Redirige a la página de destino
header("location: ../../../vistas/vistasAdmin/tipoHabitaciones.php");
