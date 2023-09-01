<?php

include_once "../../config/conex.php";
date_default_timezone_set("America/Bogota");
session_start();

if (!empty($_POST['numHabitacion']) && !empty($_POST['tipoHab']) && !empty($_POST['observaciones'])) {

    $numHab =  $_POST['numHabitacion'];
    $tipoHab = $_POST['tipoHab'];
    $descripcionHab = $_POST['observaciones'];
    $estadoHab = 1; // los diferentes tipos de estados que tiene la habitacion 1: disponible, 2: limpieza, 3: mantenimiento, 4: ocupado
    $estado = 1; // estado si la habitacion esta deshabilitada o no
    $fecha = date("y/m/d");
    $hora = date("G:i:s");

    $existe = false;

    $consulta = $dbh->prepare("SELECT id, nHabitacion FROM habitaciones WHERE nHabitacion = :numHab");
    $consulta->bindParam(":numHab", $numHab);
    $consulta->execute();

    if ($consulta->rowCount() > 0) {
        $_SESSION['msjError'] = "Esta habitación ya existe";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        $existe = true;
    } else {
        $sql = $dbh->prepare("INSERT INTO habitaciones(nHabitacion, id_tipo, id_hab_estado, observacion, estado, fecha, hora, fecha_sys) VALUES (:nHab, :idTipo, :idHabEstado, :observacion, :estado, :fecha, :hora, now())");

        $sql->bindParam(":nHab", $numHab);
        $sql->bindParam(":idTipo", $tipoHab);
        $sql->bindParam(":idHabEstado", $estadoHab);
        $sql->bindParam(":observacion", $descripcionHab);
        $sql->bindParam(":estado", $estado);
        $sql->bindParam(":fecha", $fecha);
        $sql->bindParam(":hora", $hora);

        if (!$existe && $sql->execute()) {
            $_SESSION['msjExito'] = "Habitación registrada con exito";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        } else {
            $_SESSION['msjError'] = "Ocurrió un error";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        }
    }

} else {
    $_SESSION['msjError'] = "Campos vacíos";
    header("location: ../../../vistas/vistasAdmin/habitaciones.php");
}


?>