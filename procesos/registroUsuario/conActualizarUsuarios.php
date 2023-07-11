<?php

include "../config/conex.php";

//* DATOS DEL FORMULARIO
echo $idUsuario = $_POST['id_usuario'];
echo $pNombre = $_POST['primerNombreUsuario'];
echo $sNombre = $_POST['segundoNombreUsuario'];
echo $pApellido = $_POST['primerApellidoUsuario'];
echo $sApellido = $_POST['segundoApellidoUsuario'];
echo $documento = $_POST['documentoUsuario'];
echo $telefono = $_POST['telefonoUsuario'];
echo $email = $_POST['emailUsuario'];
echo $usuario = $_POST['usuario'];
echo $contraseña = $_POST['contraseña'];

//* SQL DE ACTUALIZAR
$sql = $dbh -> prepare("UPDATE infousuarios, usuarios SET infousuarios.documento=:documento,infousuarios.pNombre=:pNombre,infousuarios.sNombre=:sNombre,infousuarios.pApellido=:pApellido,infousuarios.sApellido=:sApellido,infousuarios.celular=:celular,infousuarios.email=:email, usuarios.usuario =:usuario, usuarios.contraseña =:contra, usuarios.fecha_sys = now() WHERE infousuarios.id_infoUsuario = usuarios.id_infoUsuario and usuarios.idUsuario = :idUsuario"); //Preparar la consulta


/* $sql = "UPDATE infousuarios, usuarios SET infousuarios.documento='$documento', infousuarios.pNombre='$pNombre',infousuarios.sNombre='$sNombre',infousuarios.pApellido='$pApellido',infousuarios.sApellido='$sApellido',infousuarios.celular='$telefono',infousuarios.email='$email', usuarios.usuario ='$usuario', usuarios.contraseña ='$contraseña', usuarios.fecha_sys = now() WHERE infousuarios.id_infoUsuario = usuarios.id_infoUsuario and usuarios.idUsuario = '$idUsuario'"; */

// ENLAZAR LOS MARCADORES CON LAS VARIABLES
$sql -> bindParam(':documento',$documento);
$sql -> bindParam(':pNombre',$pNombre);
$sql -> bindParam(':sNombre',$sNombre);
$sql -> bindParam(':pApellido',$pApellido);
$sql -> bindParam(':sApellido',$sApellido);
$sql -> bindParam(':celular',$telefono);
$sql -> bindParam(':email',$email);
$sql -> bindParam(':usuario',$usuario);
$sql -> bindParam(':contra',$contraseña);
$sql -> bindParam(':idUsuario',$idUsuario);

/* if(!$dbh -> query($sql)){ // Ejecutar consulta
    echo "ERROR";
}else{
    header("location: ../../vistas/vistasAdmin/usuarios.php");
    session_start();
    $_SESSION['msjActualizado'] = "Actualizado";
} */

if($sql -> execute()){
    header("location: ../../vistas/vistasAdmin/usuarios.php");
    session_start();
    $_SESSION['msjActualizado'] = "Actualizado";
}else{
    echo "ERROR";
}

?>