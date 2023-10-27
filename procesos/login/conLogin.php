<?php

session_start();

include_once "../config/conex.php";

//* HACER LA VALIDACION DEL INICIO DE SESION SI LOS CAMPOS NO ESTAN VACIOS SE HACE LA CONSULTA A LA BD

if (!empty($_POST['usuario']) && !empty($_POST['contraseña'])) {


    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $estado = 1;

    $validar = $dbh -> prepare("SELECT usuarios.idUsuario, usuarios.id_rol, usuarios.usuario, usuarios.contraseña, infousuarios.pNombre, infousuarios.pApellido FROM usuarios JOIN infousuarios ON usuarios.id_infoUsuario = infousuarios.id_infoUsuario WHERE usuarios.usuario = :usua and usuarios.estado = :estado"); //* preparar la consulta

    //* Bloque para enlazar los marcadores con las variables
    $validar -> bindParam(':usua', $usuario);
    $validar -> bindParam(':estado', $estado);
    $validar -> execute(); //* Realizar la consulta


    //* Condicion para obtener el resultado de la consulta

    $contador = 0;

    foreach($validar->fetchAll(PDO::FETCH_ASSOC) as $datos){

        $contador +=1;

        $contrasenaBD = $datos['contraseña'];
        $_SESSION['idUsuario'] = $datos['idUsuario']; //* Guardar el id en una sesion
        $_SESSION['pNombre'] = $datos['pNombre'];
        $_SESSION['pApellido'] = $datos['pApellido'];
        $_SESSION['tipoUsuario'] = $datos['id_rol'];
        $_SESSION['usuario'] = $datos['usuario']; //* guardar el usuario en una sesion
    }

    if($contador == 0){
        $_SESSION['error'] = "Usuario o Contraseña Incorrecta";
        header("location: ../../vistas/login.php");
    }else{
        if(password_verify($contraseña, $contrasenaBD)){
            header("location: ../../vistas/vistasAdmin/inicio.php");
        }else{
            $_SESSION['error'] = "Usuario o Contraseña Incorrecta";
            header("location: ../../vistas/login.php");
        }
    }
    
} else {
        $_SESSION['error'] = "Campos Vacios";
        header("location: ../../vistas/login.php");
}

?>