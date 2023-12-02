<?php

session_start();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../iconos/logo_icono.png">
    <link rel="stylesheet" href="../librerias/bootstrap-icons-1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../librerias/sweetAlert2/css/sweetalert2.min.css">
    <script src="../librerias/sweetAlert2/js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../css/estilosLogin.css">
    <title>LOGIN</title>
</head>

<body>

    <div class="contenedorPrin">
        <a href="login.php"><i class="bi bi-arrow-bar-left"></i> REGRESAR</a>
        <div class="contenedorLogin">
            <div class="ConImgLogin">
                <div class="imgLogin">
                    <img src="../iconos/iconoLogin.png" alt="Icono del login">
                </div>
            </div>
            <div class="login">
                <div class="formLogin">

                    <h1 class="recuperarh1">RECUPERAR CONTRASEÑA</h1>
                    <form action="../procesos/login/conOlvContraseña.php" method="post" id="form">

                        <div class="userInput">
                            <label aria-label="Usuario">
                                <input type="text" class="usuarioInput" placeholder="Usuario" id="usuario" name="usuario" required>
                                <i class="bi bi-person"></i>
                            </label>
                        </div>

                        <div class="passInput">
                            <label for="documento" aria-label="Documento">
                                <input type="text" class="contraseñaInput" placeholder="Documento" id="documento" name="documento" required>
                                <i class="bi bi-file-earmark-medical"></i>
                            </label>
                        </div>

                        <div class="btnIngresar">
                            <input type="submit" value="Recuperar" name="btnUsuario" id="usuario">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- ALERTA MOSTRANDO LA CONTRASEÑA -->

    <?php

    if (isset($_SESSION['msjError'])) :
    ?>
        <script>
            Swal.fire({
                position: '',
                icon: 'error',
                title: '¡Ocurrió un error!',
                text: '<?php echo $_SESSION['msjError']; ?>',
                showConfirmButton: true
            });
        </script>
    <?php
        unset($_SESSION['msjError']);
    endif;

    ?>

</body>

</html>