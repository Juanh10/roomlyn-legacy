<?php

include "../config/conex.php";

$idUsuario = $_POST['id_usuario'];

$estado = 0;

$sql = $dbh -> prepare("UPDATE usuarios SET estado = :estado WHERE idUsuario = :idUsuario");

$sql -> bindParam(':estado', $estado);
$sql -> bindParam(':idUsuario', $idUsuario);

if($sql -> execute()){
    header("location: ../../vistas/vistasAdmin/usuarios.php");
    session_start();
    $_SESSION['msjEliminar'] = "Deshabilitado";
}else{
    echo "ERROR";
}


?>