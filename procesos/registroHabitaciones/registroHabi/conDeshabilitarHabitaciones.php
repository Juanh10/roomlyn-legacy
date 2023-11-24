<?php
include_once "../../config/conex.php";
session_start();

if(!empty($_POST['idHab'])){

    $idHab = $_POST['idHab'];
    $estado = 0;

    $sql = $dbh -> prepare("UPDATE habitaciones SET estado=:estado WHERE id_habitacion = :idHab");
    $sql -> bindParam(":estado", $estado);
    $sql -> bindParam(":idHab", $idHab);

    $sqlElemento = $dbh->prepare("UPDATE habitaciones_elementos_selec SET estado = :estado WHERE id_habitacion = :idHab");

    if($sql -> execute()){

        $sqlElemento->bindParam(':estado',$estado);
        $sqlElemento->bindParam(':idHab',$idHab);

        if($sqlElemento->execute()){
            $_SESSION['msjExito'] = "¡La habitación se ha deshabilitado exitosamente!";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        }else{
            $_SESSION['msjError'] = "Ha habido un error al intentar deshabilitar la habitación. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        }

    }else{
        $_SESSION['msjError'] = "Ha habido un error al intentar deshabilitar la habitación. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    }

}
?>