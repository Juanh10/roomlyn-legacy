<?php

include_once "../../config/conex.php";

if (isset($_POST['actTipo'])) {

    session_start();

    if (!empty($_POST['nombreTipo']) && !empty($_POST['cantidadCamas']) && !empty($_POST['cantidadPersonas']) && !empty($_POST['precioVentilador']) && !empty($_POST['precioAire'])) {

        $idTipoHab = $_POST['idTipoHab'];
        $nombreTipo = $_POST['nombreTipo'];
        $cantidadCamas = $_POST['cantidadCamas'];
        $cantidadPersonas = $_POST['cantidadPersonas'];
        $precioVentilador = $_POST['precioVentilador'];
        $precioAire = $_POST['precioAire'];

        $sql = $dbh->prepare("UPDATE habitaciones_tipos SET tipoHabitacion= :tipoHab, cantidadCamas= :cantidadCama, capacidadPersonas= :cantidadPersona, precioVentilador= :precioVentilador, precioAire= :precioAire WHERE id = :idTipo");

        $sql->bindParam(':tipoHab', $nombreTipo);
        $sql->bindParam(':cantidadCama', $cantidadCamas);
        $sql->bindParam(':cantidadPersona', $cantidadPersonas);
        $sql->bindParam(':precioVentilador', $precioVentilador);
        $sql->bindParam(':precioAire', $precioAire);
        $sql->bindParam(':idTipo', $idTipoHab);

        if ($sql->execute()) {
            $_SESSION['msjExito'] = "Datos actualizados";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        } else {
            $_SESSION['msjError'] = "Ocurrió un error";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        }
    } else {
        $_SESSION['msjError'] = "Campos vacíos";
        header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
    }
}
