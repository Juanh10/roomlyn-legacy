<?php

include "../config/conex.php";

if (isset($_POST["btnUsuario"])) {//esta funcion sirve para saber si se preciono el boton

    if (!empty($_POST["usuario"]) && !empty($_POST["documento"])) {// esta funcion es para saber si los campos estan vacios
        
        $docu = $_POST["documento"];
        $user = $_POST["usuario"];

     $SQL= $dbh -> prepare("SELECT usuarios.contraseña FROM usuarios JOIN infousuarios ON usuarios.id_infoUsuario = infousuarios.id_infoUsuario WHERE usuarios.usuario = :usuario AND infousuarios.documento = :documento");//esta funcion sirve para preparar una consulta de la base de de datos

     $SQL->bindParam(':usuario',$user);//para vincular los marcadores":usu" con las variables
     $SQL->bindParam(':documento',$docu);
     $SQL->execute();//para ejecutar la consulta
     
     
     if ($con = $SQL->fetch()) {//buscar datos de la base de datos
        header("location: ../../vistas/vistasAdmin/usuarios.php");
         session_start();
         $_SESSION['mjscontraseña'] = $con['contraseña'];

     }
    
    }
    else {
        echo"campos vacíos";
    }
}





?>