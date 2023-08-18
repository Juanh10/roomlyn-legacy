<?php

include_once "../config/conex.php";

session_start();

$idUsuario = $_POST['id_usuario'];

$estado = 0;

$sql = $dbh -> prepare("UPDATE usuarios SET estado = :estado WHERE idUsuario = :idUsuario");

$sql -> bindParam(':estado', $estado);
$sql -> bindParam(':idUsuario', $idUsuario);

if($sql -> execute()){
    header("location: ../../vistas/vistasAdmin/usuarios.php");
    $_SESSION['msj2'] = "Deshabilitado";
}else{
    header("location: ../../vistas/vistasAdmin/usuarios.php");
    $_SESSION['msj2'] = "Ocurrió un error";
}


?>