<?php

if(isset($_POST['actulizarImagen'])){

    session_start();

    $idTipoHab = $_POST['idTipoHab'];

    if(isset($_FILES['imgNueva']) && $_FILES['imgNueva']['error'] == 0){

    }else{
        $_SESSION['msjError'] = "No se eligió ningún archivo";
        header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=".$idTipoHab."");
    }

}
?>