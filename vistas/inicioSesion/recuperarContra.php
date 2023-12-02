<?php 

include_once "../../procesos/config/conex.php";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            margin-top: 5px;
            border-radius: 3px;
            background-color: #000;
            border: none;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #434343;
        }

    </style>
</head>
<body>

<?php

$token = $_GET['token'];

$sqlVerificarEmpleado = $dbh->prepare("SELECT id_empleado FROM tokens_recuperacion WHERE token = :token AND fecha_expiracion > NOW()");
$sqlVerificarEmpleado->bindParam(':token', $token);
$sqlVerificarEmpleado->execute();

$sqlVerificarCliente = $dbh->prepare("SELECT id_cliente_registrado FROM tokens_recuperacion WHERE token = :token AND fecha_expiracion > NOW()");
$sqlVerificarCliente->bindParam(':token', $token);
$sqlVerificarCliente->execute();

if ($sqlVerificarEmpleado->rowCount() > 0 || $sqlVerificarCliente->rowCount() > 0) {
    ?>
    <form action="../../procesos/login/conCambiarContra.php" method="post">
        <h2>Recuperar Contraseña</h2>
        <label for="nueva_contraseña">Nueva Contraseña:</label>
        <input type="password" id="nueva_contraseña" name="nuevaContra" required>
        <label for="confirmar_contraseña">Confirmar Contraseña:</label>
        <input type="password" id="confirmar_contraseña" name="confirContra" required>
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <input type="submit" value="Cambiar Contraseña">
    </form>
    <?php
} else {
    echo 'El enlace de recuperación de contraseña no es válido o ha expirado.';
}


?>

</body>
</html>