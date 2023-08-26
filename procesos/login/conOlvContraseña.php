<?php

include_once "../config/conex.php";
session_start();

if (isset($_POST["btnUsuario"])) { //esta funcion sirve para saber si se preciono el boton

    if (!empty($_POST["usuario"]) && !empty($_POST["documento"])) { // esta funcion es para saber si los campos estan vacios

        $docu = $_POST["documento"];
        $user = $_POST["usuario"];

        $SQL = $dbh->prepare("SELECT usuarios.contraseña FROM usuarios JOIN infousuarios ON usuarios.id_infoUsuario = infousuarios.id_infoUsuario WHERE usuarios.usuario = :usuario AND infousuarios.documento = :documento"); //esta funcion sirve para preparar una consulta de la base de de datos

        $SQL->bindParam(':usuario', $user); //para vincular los marcadores":usu" con las variables
        $SQL->bindParam(':documento', $docu);

        if ($SQL->execute()) { // para ejecutar la consulta
            if ($con = $SQL->fetch()) { //buscar datos de la base de datos
                header("location: ../../vistas/login.php");
                $_SESSION['mjscontraseña'] = $con['contraseña'];
            } else {
                header("location: ../../vistas/login.php");
                $_SESSION['mjsError'] = "El usuario o documento son incorrectos";
            }
        } else {
            header("location: ../../vistas/login.php");
            $_SESSION['mjsError'] = "Ocurrió un error";
        }

    } else {
        header("location: ../../vistas/login.php");
        $_SESSION['mjsError'] = "Campos vacios";
    }
}

?>