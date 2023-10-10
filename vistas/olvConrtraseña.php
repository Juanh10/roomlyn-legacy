<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../iconos/logo_icono.png">
    <link rel="stylesheet" href="../librerias/bootstrap-icons-1.10.5/font/bootstrap-icons.css">
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

                        <label class="userInput" aria-label="Usuario">
                            <input type="text" class="usuarioInput" placeholder="Usuario" id="usuario" name="usuario" required>
                            <i class="bi bi-person"></i>
                        </label>

                        <label for="documento" class="passInput" aria-label="Documento">
                            <input type="text" class="contraseñaInput" placeholder="Documento" id="documento" name="documento" required>
                            <i class="bi bi-file-earmark-medical"></i>
                        </label>

                        <div class="btnIngresar">
                            <input type="submit" value="Recuperar" name="btnUsuario" id="usuario">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- ALERTA MOSTRANDO LA CONTRASEÑA -->


    


</body>

</html>