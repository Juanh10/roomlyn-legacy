<?php

include "../../config/conex.php";

if(isset($_POST['registrarServicio'])){
    if(!empty($_POST['servicio'])){

        session_start();
        
        $servicio = $_POST['servicio'];
    
        $sql = $dbh -> prepare("INSERT INTO habitaciones_elementos(elemento, fecha_sys) VALUES (:elemento, now())");
    
        $sql -> bindParam(':elemento', $servicio);
    
        if($sql -> execute()){
            header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
            $_SESSION['mensaje'] = "REGISTRADO";
        }else{
            echo "ERROR";
        }
    
    }else{
        header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
        $_SESSION['mensaje'] = "Campos vacios";
    }
}
