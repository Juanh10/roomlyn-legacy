<?php
session_start();

include_once "../config/conex.php";

// Verificar si los campos necesarios no están vacíos
if (!empty($_POST['idHabitacion']) && !empty($_POST['idReserva'])) {

    // Obtener valores del formulario
    $idReserva = $_POST['idReserva'];
    $idHab = $_POST['idHabitacion'];
    $estado = 3; // Estado para reserva cancelada
    $estadoHab = 1; // Estado para habitación disponible

    // Preparar consultas SQL para actualizar la reserva y la habitación
    $sql = $dbh->prepare("UPDATE reservas SET id_estado_reserva = :idEstado WHERE id_reserva = :idRe");
    $sqlHab = $dbh->prepare("UPDATE habitaciones SET id_hab_estado = :idEstado WHERE id_habitacion = :idHab");

    // Enlazar parámetros
    $sql->bindParam(':idEstado', $estado);
    $sql->bindParam(':idRe', $idReserva);

    // Ejecutar la consulta para actualizar la reserva
    if ($sql->execute()) {
        $sqlHab->bindParam(':idEstado', $estadoHab);
        $sqlHab->bindParam(':idHab', $idHab);

        // Ejecutar la consulta para actualizar la habitación
        if ($sqlHab->execute()) {
            $_SESSION['msjCn'] = "Reserva cancelada correctamente";
            header("Location: ../../vistas/vistasRegistroClientes/reservasRealizadas.php");
            exit;
        } else {
            $_SESSION['msjCn'] = "Ha habido un error al intentar cancelar la reserva. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente. ";
            header("Location: $urlActual");
            exit;
        }
    } else {
        $_SESSION['msjCn'] = "Ha habido un error al intentar cancelar la reserva. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        header("Location: $urlActual");
        exit;
    }
} else {
    $_SESSION['msjCn'] = "Ha habido un error al intentar cancelar la reserva. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
    header("Location: $urlActual");
    exit;
}
?>