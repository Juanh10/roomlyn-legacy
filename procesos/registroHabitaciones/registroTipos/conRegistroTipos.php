<?php

include "../../config/conex.php";

if(!empty($_POST['tipoHabitacion']) && !empty($_POST['cantiCama']) && !empty($_POST['opcioneServicios'])){

    echo $tipoHabitacion = $_POST['tipoHabitacion'];
    echo $cantidadCama = $_POST['cantiCama'];
    $opcioneServicios = $_POST['opcioneServicios'];

    foreach($opcioneServicios as $opciones){
        echo "OPCIONES".$opciones;
    }

    $sql = $dbh -> prepare("INSERT INTO habitaciones_tipos(tipoHabitacion, cantidadCamas, fecha_sys) VALUES (:tipoHabitacion, :cantiCama,now())");

    $sql -> bindParam(':tipoHabitacion', $tipoHabitacion);
    $sql -> bindParam(':cantiCama',$cantidadCama);

    $sql2 = $dbh -> prepare("INSERT INTO habitaciones_tipos_elementos(id_habitacion_tipo, id_elemento) VALUES (:idTipoHabi,:idServicio)");

    if($sql -> execute()){

        $ultID = $dbh -> lastInsertId('habitaciones_tipos');
        $sql2 -> bindParam(':idTipoHabi', $ultID);

        foreach($opcioneServicios as $opciones){
            $sql2 -> bindParam('idServicio',$opciones);
            if($sql2 -> execute()){
                header("location: ../../../vistas/vistasAdmin/habitaciones.php");
                session_start();
                $_SESSION['msjRegistradoTipoH'] = "REGISTRADO";
            }else{
                echo "ERROR";
            }
        }


    }else{
        echo "ERROR";
    }

}else{
    echo "CAMPOS VACIOS";
}

?>