<?php
session_start();

if(empty($_SESSION['idUsuario'])){ //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

/* echo $_SESSION['idUsuario'];
echo $_SESSION['pNombre'];
echo $_SESSION['pApellido'];
echo $_SESSION['tipoUsuario']; */

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "menuAdmin.php"; ?>
    <title>Reservas</title>
</head>
<body>

<div class="contenido">
    <h1>RESERVACIONES</h1>
</div>
    
</body>
</html>