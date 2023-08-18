<?php

include "../../config/conex.php";

if(isset($_POST['btnDeshabilitar'])){

    session_start();

    if(!empty($_POST['idTipoHab'])){
        
        $idTipo = $_POST['idTipoHab'];

        $estado = 0;

        $sql = $dbh -> prepare("UPDATE habitaciones_tipos SET estado=:estado WHERE id = :idTipo");

        $sql -> bindParam(':estado', $estado);
        $sql -> bindParam(':idTipo', $idTipo);

        if($sql -> execute()){
            $_SESSION['msjExito'] = "Deshabilitado";
            header("location: ../../../vistas/vistasAdmin/tipoHabitaciones.php");
        }else{
            echo "OCURRIÓ UN ERROR";
            $_SESSION['msjError'] = "Ocurrió un error";
            header("location: ../../../vistas/vistasAdmin/tipoHabitaciones.php");
        }

    }
}

?>