<?php

include_once "../config/conex.php";

session_start();

if (!empty($_POST['id_usuario'])) {

    $idUsuario = $_POST['id_usuario'];

    $estado = 0;

    $rol = 1;

    $sqlConsulta = $dbh->prepare("SELECT id_rol FROM empleados WHERE id_empleado = :idUsu AND id_rol = :idRol");

    $sqlConsulta->bindParam('idUsu', $idUsuario);
    $sqlConsulta->bindParam('idRol', $rol);

    $sqlConsulta->execute();

    $sql = $dbh->prepare("UPDATE empleados SET estado = :estado WHERE id_empleado = :idUsuario");

    if ($sqlConsulta->rowCount() > 0) {
        header("location: ../../vistas/vistasAdmin/usuarios.php");
        $_SESSION['msj2'] = "No es posible deshabilitar al administrador.";
    } else {
        $sql->bindParam(':estado', $estado);
        $sql->bindParam(':idUsuario', $idUsuario);

        if ($sql->execute()) {
            header("location: ../../vistas/vistasAdmin/usuarios.php");
            $_SESSION['msj2'] = "Usuario ha sido deshabilitado correctamente";
        } else {
            header("location: ../../vistas/vistasAdmin/usuarios.php");
            $_SESSION['msj2'] = "Ha habido un error al intentar deshabilitar un usuario. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        }
    }
}
?>