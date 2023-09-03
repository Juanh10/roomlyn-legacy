<?php
include_once "../../config/conex.php";
session_start();

if(!empty($_POST['idHab'])){

    $idHab = $_POST['idHab'];
    $estado = 0;

    $sql = $dbh -> prepare("UPDATE habitaciones SET estado=:estado WHERE id = :idHab");
    $sql -> bindParam(":estado", $estado);
    $sql -> bindParam(":idHab", $idHab);

    if($sql -> execute()){
        $_SESSION['msjExito'] = "¡La habitación se ha deshabilitado exitosamente!";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    }else{
        $_SESSION['msjError'] = "Campos vacíos";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    }

}
?>