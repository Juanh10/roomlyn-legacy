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

$sql = $dbh -> prepare("UPDATE info_empleados, empleados SET info_empleados.documento= :documento, info_empleados.pNombre= :pNombre, info_empleados.sNombre= :sNombre, info_empleados.pApellido= :pApellido, info_empleados.sApellido= :sApellido, info_empleados.celular= :celular, info_empleados.email= :email, empleados.usuario= :usuario, empleados.fecha_update = now()  WHERE empleados.id_empleado = :id and info_empleados.id_info_empleado = empleados.id_info_empleado");

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