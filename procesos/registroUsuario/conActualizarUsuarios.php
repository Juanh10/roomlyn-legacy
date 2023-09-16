<?php

include_once "../config/conex.php";

session_start();

//* DATOS DEL FORMULARIO
$idUsuario = $_POST['id_usuario'];
$pNombre = $_POST['primerNombreUsuario'];
$sNombre = $_POST['segundoNombreUsuario'];
$pApellido = $_POST['primerApellidoUsuario'];
$sApellido = $_POST['segundoApellidoUsuario'];
$documento = $_POST['documentoUsuario'];
$telefono = $_POST['telefonoUsuario'];
$email = $_POST['emailUsuario'];
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

//* SQL de actualizar 

$sql = $dbh -> prepare("UPDATE infousuarios, usuarios SET infousuarios.documento= :documento, infousuarios.pNombre= :pNombre, infousuarios.sNombre= :sNombre, infousuarios.pApellido= :pApellido, infousuarios.sApellido= :sApellido, infousuarios.celular= :celular, infousuarios.email= :email, usuarios.usuario= :usuario, usuarios.fecha_sys = now()  WHERE usuarios.idUsuario = :id and infousuarios.id_infoUsuario = usuarios.id_infoUsuario");

$sql -> bindParam(':id', $idUsuario);
$sql -> bindParam(':pNombre', $pNombre);
$sql -> bindParam(':sNombre', $sNombre);
$sql -> bindParam(':pApellido', $pApellido);
$sql -> bindParam(':sApellido', $sApellido);
$sql -> bindParam(':documento', $documento);
$sql -> bindParam(':celular', $telefono);
$sql -> bindParam(':email', $email);
$sql -> bindParam(':usuario', $usuario);

if($sql -> execute()){
    header("location: ../../vistas/vistasAdmin/usuarios.php");
    $_SESSION['msj2'] = "Datos actualizados";
}else{
    header("location: ../../vistas/vistasAdmin/usuarios.php");
    $_SESSION['msj2'] = "Ocurrió un error";
}




?>