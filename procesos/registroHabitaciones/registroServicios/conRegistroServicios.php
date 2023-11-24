<?php

session_start();
include_once "../../config/conex.php";

if(isset($_POST['registrarServicio'])){
    if(!empty($_POST['servicio'])){

        
        $servicio = $_POST['servicio'];
    
        $sql = $dbh -> prepare("INSERT INTO habitaciones_servicios(servicio, fecha_sys) VALUES (:elemento, now())");
    
        $sql -> bindParam(':elemento', $servicio);
    
        if($sql -> execute()){
            header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
            $_SESSION['mensaje'] = "Servicio registrado con exito";
        }else{
            $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        }
    
    }else{
        header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
        $_SESSION['mensaje'] = "Campos vacios. Por favor llena todos lo campos.";
    }
}

if(isset($_POST['registrarElemento'])){

    if(!empty($_POST['elemento'])){

        $servicio = $_POST['elemento'];
    
        $sql = $dbh -> prepare("INSERT INTO habitaciones_elementos(elemento, fecha_sys) VALUES (:elemento, now())");
    
        $sql -> bindParam(':elemento', $servicio);
    
        if($sql -> execute()){
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
            $_SESSION['msjExito'] = "Elemento registrado con exito";
        }else{
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
            $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        }

    }else{
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        $_SESSION['msjError'] = "Campos vacios. Por favor llena todos los campos";
    }

}
