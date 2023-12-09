<?php
include_once "../../config/conex.php"; // Incluir el archivo de conexión a la base de datos
session_start(); // Iniciar la sesión

// Verificar si se ha enviado el ID de la habitación
if (!empty($_POST['idHab'])) {
    $idHab = $_POST['idHab']; // Obtener el ID de la habitación desde el formulario
    $estado = 0; // Estado para deshabilitar la habitación

    // Preparar la consulta para deshabilitar la habitación
    $sql = $dbh->prepare("UPDATE habitaciones SET estado=:estado WHERE id_habitacion = :idHab");
    $sql->bindParam(":estado", $estado);
    $sql->bindParam(":idHab", $idHab);

    // Preparar la consulta para deshabilitar los elementos seleccionados asociados a la habitación
    $sqlElemento = $dbh->prepare("UPDATE habitaciones_elementos_selec SET estado = :estado WHERE id_habitacion = :idHab");

    // Ejecutar la consulta para deshabilitar la habitación
    if ($sql->execute()) {

        // Enlazar los parámetros y ejecutar la consulta para deshabilitar los elementos seleccionados
        $sqlElemento->bindParam(':estado', $estado);
        $sqlElemento->bindParam(':idHab', $idHab);

        // Ejecutar la consulta para deshabilitar los elementos seleccionados
        if ($sqlElemento->execute()) {
            $_SESSION['msjExito'] = "¡La habitación se ha deshabilitado exitosamente!";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        } else {
            $_SESSION['msjError'] = "Ha habido un error al intentar deshabilitar la habitación. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        }

    } else {
        $_SESSION['msjError'] = "Ha habido un error al intentar deshabilitar la habitación. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    }
}
?>