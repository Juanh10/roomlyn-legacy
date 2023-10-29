<?php

session_start();

include_once "../../config/conex.php";

if (!empty($_POST['idTipoHab'])) {

    $idTipo = $_POST['idTipoHab'];

    $estado = 0;

    $sql = $dbh->prepare("UPDATE habitaciones_tipos SET estado=:estado WHERE id_hab_tipo = :idTipo");
    $sql2 = $dbh->prepare("UPDATE habitaciones SET estado=:estado2 WHERE id_hab_tipo = :idTipo2");

    $sql->bindParam(':estado', $estado);
    $sql->bindParam(':idTipo', $idTipo);

    if ($sql->execute()) {

        $sql2 -> bindParam(':estado2', $estado);
        $sql2 -> bindParam(':idTipo2', $idTipo);

        if($sql2 -> execute()){
            $_SESSION['msjExito'] = "¡Se ha deshabilitado correctamente!";
            header("location: ../../../vistas/vistasAdmin/tipoHabitaciones.php");
        }
    } else {
        echo "OCURRIÓ UN ERROR";
        $_SESSION['msjError'] = "Ocurrió un error";
        header("location: ../../../vistas/vistasAdmin/tipoHabitaciones.php");
    }
}
