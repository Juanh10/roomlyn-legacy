<?php

session_start();

if (empty($_SESSION['id_cliente_registrado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

$idCliente = $_SESSION['id_cliente_registrado'];
$nombres = explode(" ", $_SESSION['nombres']);
$apellidos = explode(" ", $_SESSION['apellidos']);

$primerNombre = $nombres[0];
$primerApellido = $apellidos[0];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "dependencias.php" ?>
    <title>Configuración</title>
</head>

<body>

    <!--* PRELOADER CARGAR PAGINA WEB -->

    <div class="contenedorPreloader" id="onload">
        <div class="lds-default">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <header class="cabecera">
        <div class="contenedor navContenedor">
            <div class="logoPlahot">
                <a href="../../index.php"><img src="../../iconos/logoPlahot2.png" alt="Logo de la plataforma web"></a>
            </div>
            <div class="menuRespon">
                <div class="icono">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <nav class="navegacion">
                <ul>
                    <li class="inicioSesionCliente" title="Conectado">
                        <a href="configuracionCuenta.php" class="inicioSesion"><span class="conexion"></span><?php echo $primerNombre." ".$primerApellido ?></a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container contenedorPrincipal mx-auto">
            <h1>Configuración de la cuenta</h1>
            <div class="row">
                <div class="col-6 columnaDatos">
                    <div class="cardDatos">
                        <div class="row">
                            <div class="col-1">
                                <div class="iconoCard">
                                    <i class="bi bi-person-fill-add"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="datos">
                                    <h2>Datos personales</h2>
                                    <p>En esta sección, puedes actualizar y gestionar tus datos personales</p>
                                    <a href="gestionarDatos.php">Gestionar los datos personales</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cardDatos">
                        <div class="row">
                            <div class="col-1">
                                <div class="iconoCard">
                                    <i class="bi bi-person-fill-lock"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="datos">
                                    <h2>Seguridad</h2>
                                    <p>En esta sección, tienes la posibilidad de modificar tus configuraciones de seguridad, cambiar tu contraseña o eliminar tu cuenta.</p>
                                    <a href="gestionarSeguridad.php">Gestionar los ajustes de seguridad</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 columnaDatos">
                <div class="cardDatos">
                        <div class="row">
                            <div class="col-1">
                                <div class="iconoCard">
                                <i class="bi bi-calendar-check-fill"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="datos">
                                    <h2>Reservas realizadas</h2>
                                    <p>En esta sección, encontraras todas las reservas que tienes.</p>
                                    <a href="reservasRealizadas.php">Gestionar reservas</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


        <!--* PIE DE PAGINA -->

        <footer>
        <div class="piePagina">
            <div class="copyPiePagina">
                <div class="logoPiePagina">
                    <img src="../../iconos/logoPlahot2.png" alt="Logo de la plataforma web">
                </div>
                <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
            </div>
            <div class="contenidoPiePagina">
                <div class="redes-sociales">
                    <ul>
                        <li><a href="https://www.facebook.com/profile.php?id=61550262616792" class="face" target="_blank" title="Facebook"><i class="bi bi-facebook"></i></a></li>
                        <li><a href="https://www.instagram.com/hotelcolonialci2/" class="insta" target="_blank" title="Instagram"><i class="bi bi-instagram"></i></a></li>
                        <li><a href="https://www.tiktok.com/@colonialespinal2023" class="what" target="_blank" title="Whatsapp"><i class="bi bi-whatsapp"></i></a></li>
                        <li><a href="https://www.tiktok.com/@colonialespinal2023" class="tiktok" target="_blank" title="Tik tok"><i class="bi bi-tiktok"></i></a></li>
                    </ul>
                </div>
                <div class="contPreguntas">
                    <a href="../../comoFunciona.html">Como funciona ROOMLYN</a>
                    <a href="#">Politicas de privacidad</a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>