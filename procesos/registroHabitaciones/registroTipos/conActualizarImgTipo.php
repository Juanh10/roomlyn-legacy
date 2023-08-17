<?php

include "../../config/conex.php";
session_start();

if (isset($_POST['actulizarImagen'])) {


    $idTipoHab = $_POST['idTipoHab'];

    if (isset($_FILES['imgNueva']) && $_FILES['imgNueva']['error'] == 0) {

        $idImg = $_POST['idImg']; // capturar el id de la imagen

        $imagenNueva = $_FILES['imgNueva']['name'];
        $nombreImagen = pathinfo($imagenNueva, PATHINFO_FILENAME); // capturar el nombre de la imagen
        $extensionImg = pathinfo($imagenNueva, PATHINFO_EXTENSION); // capturar la extension de la imagen
        $tmpImg = $_FILES['imgNueva']['tmp_name']; // guardar la ruta temporal donde guarda el servidor la img

        $rutaImg = $nombreImagen . "." . $extensionImg;

        $sqlImg = $dbh->prepare("UPDATE habitaciones_imagenes SET nombre= :nombre, ruta= :ruta WHERE id = :id");

        $sqlImg->bindParam(':nombre', $nombreImagen);
        $sqlImg->bindParam(':ruta', $rutaImg);
        $sqlImg->bindParam(':id', $idImg);

        if ($sqlImg->execute()) {
            move_uploaded_file($tmpImg, "../../../imgServidor/" . $rutaImg);
            $_SESSION['msjExito'] = "Actualizado :)";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        } else {
            $_SESSION['msjError'] = "Ocurrió un error";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        }
    } else {
        $_SESSION['msjError'] = "No se eligió ningún archivo";
        header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
    }
}

if(isset($_POST['eliminarImagen'])){

    session_start();
    
    if(!empty($_POST['idImg']) && !empty($_POST['idTipoHab']))  {

        $idImg2 = $_POST['idImg'];
        $idTipoHab = $_POST['idTipoHab'];

        $estadoElm = 0;

        $sqlElmImg = $dbh -> prepare("UPDATE habitaciones_imagenes SET estado = :estadoElm WHERE id = :idImgElm");

        $sqlElmImg -> bindParam(':estadoElm', $estadoElm);
        $sqlElmImg -> bindParam('idImgElm', $idImg2);

        if($sqlElmImg -> execute()){
            $_SESSION['msjExito'] = "Deshabilitado";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        }else{
            $_SESSION['msjError'] = "Ocurrió un error";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        }

    }

}


if (isset($_POST['btnAddImg'])) {

    session_start();

    $idTipoHab2 = $_POST['idTipoHab']; 

    $estadoImgNueva = 1;

    $imagenNueva = $_FILES['addImg']['name']; // capturar el nombre de la imagen junto con la extension
    $rutaTmp = $_FILES['addImg']['tmp_name'];

    $nombreImgNueva = pathinfo($imagenNueva, PATHINFO_FILENAME); // guardar unicamente el nombre de la imagen
    $extensionImgNueva = pathinfo($imagenNueva, PATHINFO_EXTENSION); // guardar unicamente la extension de la imagen

    $rutaNuevaImg = $nombreImgNueva . "." . $extensionImgNueva; // crear la nueva ruta donde se va guardar la iamgen

    $sqlImgNueva = $dbh -> prepare("INSERT INTO habitaciones_imagenes(idTipoHabitacion, nombre, ruta, estado) VALUES (:idTip, :nombre, :ruta, :estado)");

    $sqlImgNueva -> bindParam(':idTip', $idTipoHab2);
    $sqlImgNueva -> bindParam('nombre', $nombreImgNueva);
    $sqlImgNueva -> bindParam(':ruta', $rutaNuevaImg);
    $sqlImgNueva -> bindParam(':estado', $estadoImgNueva);

    if($sqlImgNueva -> execute()){
        move_uploaded_file($rutaTmp, "../../../imgServidor/" . $rutaNuevaImg);
        $_SESSION['msjExito'] = "Foto insertada";
        header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab2 . "");
    }else{
        $_SESSION['msjError'] = "Ocurrió un error";
        header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab2 . "");
    }


}
