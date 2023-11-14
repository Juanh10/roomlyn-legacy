<?php

session_start();

include_once "../config/conex.php";

if (!empty($_POST['idReserva'])) {

    $idReserva = $_POST['idReserva'];
    $estado = 3;

    $sql = $dbh->prepare("UPDATE reservas SET id_estado_reserva = :idEstado WHERE id_reserva = :idRe");

    $sql->bindParam(':idEstado', $estado);
    $sql->bindParam(':idRe', $idReserva);

    if ($sql->execute()) {

        $_SESSION['msjCn'] = "Reserva cancelada correctamente";
        header("Location: ../../vistas/vistasRegistroClientes/reservasRealizadas.php");
        exit;
    } else {
        $_SESSION['msjCn'] = "Ocurrió un error";
        header("Location: $urlActual");
        exit;
    }
}
