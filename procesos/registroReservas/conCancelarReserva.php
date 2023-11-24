<?php

session_start();

include_once "../config/conex.php";

if (!empty($_POST['idHabitacion']) && !empty($_POST['idReserva'])) {

    $idReserva = $_POST['idReserva'];
    $idHab = $_POST['idHabitacion'];
    $estado = 3;
    $estadoHab = 1;

    $exitoSql = false;
    $exitoSqlHab = false;

    $sql = $dbh->prepare("UPDATE reservas SET id_estado_reserva = :idEstado WHERE id_reserva = :idRe");
    $sqlHab = $dbh->prepare("UPDATE habitaciones SET id_hab_estado = :idEstado WHERE id_habitacion = :idHab");

    $sql->bindParam(':idEstado', $estado);
    $sql->bindParam(':idRe', $idReserva);


    if ($sql->execute()) {
        $sqlHab->bindParam(':idEstado', $estadoHab);
        $sqlHab->bindParam(':idHab', $idHab);

        if ($sqlHab->execute()) {
            $_SESSION['msjCn'] = "Reserva cancelada correctamente";
            header("Location: ../../vistas/vistasRegistroClientes/reservasRealizadas.php");
            exit;
        } else {
            $_SESSION['msjCn'] = "Ocurrió un error";
            header("Location: $urlActual");
            exit;
        }
    } else {
        $_SESSION['msjCn'] = "Ocurrió un error";
        header("Location: $urlActual");
        exit;
    }
} else {
    $_SESSION['msjCn'] = "Campos vacios";
    header("Location: $urlActual");
    exit;
}

?>