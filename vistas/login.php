<?php

session_start();

include "../procesos/config/conex.php";

$sql = $dbh->prepare("SELECT tipoUsuario FROM usuarios WHERE tipoUsuario = 'administrador'"); // consulta sobre el tipo de usuario

$sql->execute();

$validarTipoUsuario = false;

if ($sql->fetch()) { // si ya existe un administrador en el tipo de usuario entonces pasa a true la variable
    $validarTipoUsuario = true;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilosLogin.css">
    <!-- librerias para el diseño del login -->
    <link rel="icon" href="../iconos/logo_icono.png">
    <link rel="stylesheet" href="../librerias/sweetAlert2/css/sweetalert2.min.css">
    <link rel="stylesheet" href="../librerias/bootstrap-icons-1.10.5/font/bootstrap-icons.css">
    <script src="../librerias/sweetAlert2/js/sweetalert2.all.min.js"></script>
    <title>LOGIN</title>
</head>

<body>

    <div class="contenedorPrin">
        <a href="../index.html"><i class="bi bi-arrow-bar-left"></i> REGRESAR</a>
        <div class="contenedorLogin">
            <div class="ConImgLogin">
                <div class="imgLogin">
                    <img src="../iconos/iconoLogin.png" alt="Icono del login">
                </div>
            </div>
            <div class="login">
                <div class="formLogin">

                    <h1>LOGIN</h1>

                    <form action="../procesos/login/conLogin.php" method="post" id="form">

                        <?php

                        //* verificar si existe una sesion de error

                        if (!empty($_SESSION['error'])) {
                        ?>
                            <span class="cmpVacio"><?php echo $_SESSION['error']; ?></span>
                        <?php
                            unset($_SESSION['error']); //* Eliminar el mensaje
                        }
                        ?>

                        <label class="userInput" for="user">
                            <i class="bi bi-person"></i>
                            <input class="usuarioInput" type="text" placeholder="Usuario" id="user" name="usuario" required>
                            <span></span>
                        </label>

                        <label class="passInput" for="pass">
                            <i class="bi bi-lock"></i>
                            <span class="verContraseña"><i class="bi bi-eye"></i></span>
                            <input class="contraseñaInput" type="password" placeholder="Contraseña" id="pass" name="contraseña" required>
                            <span></span>
                        </label>

                        <div class="btnIngresar">
                            <input type="submit" value="Ingresar" name="btnSubmit" id="btnSubmit">
                            <div class="opcionesFormu">
                                <?php
                                if (!$validarTipoUsuario) : // si ya existe un tipo de usuario administrador no debe aparecer "Registrar" en el login
                                ?>
                                    <a href="registroUsuarios.php">Registrar |</a>
                                <?php
                                endif;
                                ?>

                                <a href="olvConrtraseña.php">¿Olvidaste tu contraseña?</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php

    if (isset($_SESSION['mjscontraseña'])) {
    ?>

        <script>
            Swal.fire('Contraseña generada: <?php echo $_SESSION['mjscontraseña']; ?>')
        </script>

    <?php
        unset($_SESSION['mjscontraseña']);
    }

    ?>

    <script src="../librerias/jquery-3.7.0.min.js"></script>

    <script src="../js/scriptLogin.js"></script>


</body>

</html>