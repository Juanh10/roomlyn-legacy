<?php

include "../../config/conex.php";

if(isset($_POST['registrarServicio'])){
    if(!empty($_POST['servicio'])){
        
        $servicio = $_POST['servicio'];
    
        $sql = $dbh -> prepare("INSERT INTO habitaciones_elementos(elemento, fecha_sys) VALUES (:elemento, now())");
    
        $sql -> bindParam(':elemento', $servicio);
    
        if($sql -> execute()){
            header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
            session_start();
            $_SESSION['msjRegistradoServicio'] = "REGISTRADO";
        }else{
            echo "ERROR";
        }
    
    }else{
        header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
        session_start();
        $_SESSION['msjCamposVacios'] = "Campos vacios";
    }
}
