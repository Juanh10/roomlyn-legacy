<?php
session_start();

include_once "../config/conex.php";

if (!empty($_POST['cancelReserva'])) {

    if (!empty($_POST['idHab']) && !empty($_POST['idRes'])) {

        $idReserva = $_POST['idRes'];
        $idHab = $_POST['idHab'];
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
                $_SESSION['msjExito'] = "Reserva cancelada correctamente";
                header("Location: ../../vistas/vistasAdmin/recepcion.php");
                exit;
            }else{
                $_SESSION['msjError'] = "Ha habido un error al intentar cancelar la reserva. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                header("Location: $urlActual");
                exit;
            }
            
        }else{
            $_SESSION['msjError'] = "Ha habido un error al intentar cancelar la reserva. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
            header("Location: $urlActual");
            exit;
        }

    }
}


if (!empty($_POST['confirmReserva'])) {

    if (!empty($_POST['idHab']) && !empty($_POST['idRes'])) {

        $idReserva = $_POST['idRes'];
        echo $idHab = $_POST['idHab'];
        $estado = 2;
        $estadoHab = 6;

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
                $_SESSION['msjExito'] = "La reserva ha sido confirmada correctamente";
                header("Location: ../../vistas/vistasAdmin/recepcion.php");
                exit;
            }else{
                $_SESSION['msjError'] = "Ha habido un error al intentar confirmar la reserva. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                header("Location: $urlActual");
                exit;
            }
            
        }else{
            $_SESSION['msjError'] = "Ha habido un error al intentar confirmar la reserva. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
            header("Location: $urlActual");
            exit;
        }

    }
}
