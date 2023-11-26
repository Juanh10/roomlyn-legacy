<?php

session_start();

include_once "../config/conex.php";

if (!empty($_POST['checkIn'])) {

    if (!empty($_POST['idHab']) && !empty($_POST['idRes'])) {

        $idReserva = $_POST['idRes'];
        $idHab = $_POST['idHab'];
        $estado = 2;
        $estadoHab = 4;

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
                $_SESSION['msjExito'] = "¡Check-in realizado con éxito!";
                header("Location: ../../vistas/vistasAdmin/recepcion.php");
                exit;
            }else{
                $_SESSION['msjError'] = "Se ha producido un error al intentar confirmar el proceso de entrada del cliente. Por favor, te solicitamos amablemente que nos contactes a través del correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente. ";
                header("Location: $urlActual");
                exit;
            }
            
        }else{
            $_SESSION['msjError'] = "Se ha producido un error al intentar confirmar el proceso de entrada del cliente. Por favor, te solicitamos amablemente que nos contactes a través del correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente. ";
            header("Location: $urlActual");
            exit;
        }

    }
}


if (!empty($_POST['checkOut'])) {

    if (!empty($_POST['idHab']) && !empty($_POST['idRes'])) {

        $idReserva = $_POST['idRes'];
        $idHab = $_POST['idHab'];
        $estado = 4;
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
                $_SESSION['msjExito'] = "¡Check-out realizado con éxito!";
                header("Location: ../../vistas/vistasAdmin/recepcion.php");
                exit;
            }else{
                $_SESSION['msjError'] = "Se ha producido un error al intentar confirmar el proceso de salida del cliente. Por favor, te solicitamos amablemente que nos contactes a través del correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente. ";
                header("Location: $urlActual");
                exit;
            }
            
        }else{
            $_SESSION['msjError'] = "Se ha producido un error al intentar confirmar el proceso de salida del cliente. Por favor, te solicitamos amablemente que nos contactes a través del correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente. ";
            header("Location: $urlActual");
            exit;
        }

    }
}


?>