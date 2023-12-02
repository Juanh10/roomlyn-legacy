<?php

include_once "../../config/conex.php";

if(isset($_POST['btnActElemento'])){
    if (!empty($_POST['idServicio']) && !empty($_POST['servicioAct'])) {
    
        $idServicio = $_POST['idServicio'];
        $servicioAct = $_POST['servicioAct'];
    
        $sql = $dbh->prepare("UPDATE habitaciones_elementos SET elemento =:servicio,fecha_sys=now() WHERE id_hab_elemento = :idServicios");
    
        $sql->bindParam(':servicio', $servicioAct);
        $sql->bindParam(':idServicios', $idServicio);
    
        if ($sql->execute()) {
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
            session_start();
            $_SESSION['msjExito'] = "El elemento ha sido actualizado exitosamente";
        } else {
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
            $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico roomlyn@gmail.com para informarnos sobre este inconveniente.";
        }
    } else {
        session_start();
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        $_SESSION['msjError'] = "Por favor, complete todos los campos del formulario.";
    }
}

if(isset($_POST['btnActServ'])){
    if (!empty($_POST['idServicio']) && !empty($_POST['servicioAct'])) {
    
        $idServicio = $_POST['idServicio'];
        $servicioAct = $_POST['servicioAct'];
    
        $sql = $dbh->prepare("UPDATE habitaciones_servicios SET servicio =:servicio, fecha_sys=now() WHERE id_servicio = :idServicios");
    
        $sql->bindParam(':servicio', $servicioAct);
        $sql->bindParam(':idServicios', $idServicio);
    
        if ($sql->execute()) {
            header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
            session_start();
            $_SESSION['mensaje'] = "El servicio ha sido actualizado exitosamente";
        } else {
            header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
            $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico roomlyn@gmail.com para informarnos sobre este inconveniente.";
        }
    } else {
        session_start();
        header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
        $_SESSION['msjError'] = "Por favor, complete todos los campos del formulario.";
    }
}