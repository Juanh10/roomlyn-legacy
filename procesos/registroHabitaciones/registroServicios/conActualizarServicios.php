<?php

include "../../config/conex.php";

$idServicio = $_POST['idServicio'];
$servicioAct = $_POST['servicioAct'];

$sql = $dbh -> prepare("UPDATE habitaciones_elementos SET elemento=:servicio,fecha_sys=now() WHERE id = :idServicios");

$sql -> bindParam(':servicio',$servicioAct);
$sql -> bindParam(':idServicios',$idServicio);

if($sql -> execute()){
    header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
    session_start();
    $_SESSION['mensaje'] = "ACTUALIZADO";
}else{
    header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
    $_SESSION['mensaje'] = "ERROR";
}

?>