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
                        <a href="configuracionCuenta.php" class="inicioSesion"><span class="conexion"></span><?php echo $primerNombre . " " . $primerApellido ?></a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container contenedorPrincipal mx-auto">
            <h1>Configuración de la cuenta</h1>
            <div class="row">
                <div class="col columnaDatos">

                    <div class="cardDatos">
                        <div class="row">
                            <div class="col-12 col-md-3 colIconTitulo d-flex align-items-center justify-content-center">
                                <div class="iconCard">
                                    <p class="tituloConfig"><i class="bi bi-person-fill-add"></i><span>Datos personales</span></p>
                                </div>
                            </div>
                            <div class="col-12 col-md-9">
                                <div class="row align-items-stretch">
                                    <div class="col-8 columnaDatos d-flex align-items-center justify-content-center">
                                        <div class="datos">
                                            <p>En esta sección, puedes actualizar y gestionar tus datos personales. Tu experiencia personalizada comienza aquí.</p>
                                        </div>
                                    </div>
                                    <div class="col-4 columnaBoton d-flex align-items-center justify-content-center">
                                        <div class="btnGes">
                                            <a class="btnGestion" href="gestionarDatos.php">Gestionar datos personales</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cardDatos">
                        <div class="row">
                            <div class="col-12 col-md-3 colIconTitulo d-flex align-items-center justify-content-center">
                                <div class="iconCard">
                                    <p class="tituloConfig"><i class="bi bi-person-fill-add"></i><span>Seguridad</span></p>
                                </div>
                            </div>
                            <div class="col-12 col-md-9">
                                <div class="row align-items-stretch">
                                    <div class="col-8 columnaDatos d-flex align-items-center justify-content-center">
                                        <div class="datos">
                                            <p>En esta sección, tienes la posibilidad de modificar tus configuraciones de seguridad, cambiar tu contraseña o eliminar tu cuenta.</p>
                                        </div>
                                    </div>
                                    <div class="col-4 columnaBoton d-flex align-items-center justify-content-center">
                                        <div class="btnGes">
                                            <a class="btnGestion" href="gestionarSeguridad.php">Gestionar ajustes de seguridad</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cardDatos">
                        <div class="row">
                            <div class="col-12 col-md-3 colIconTitulo d-flex align-items-center justify-content-center">
                                <div class="iconCard">
                                    <p class="tituloConfig"><i class="bi bi-person-fill-add"></i><span>Reservas realizadas</span></p>
                                </div>
                            </div>
                            <div class="col-12 col-md-9">
                                <div class="row align-items-stretch">
                                    <div class="col-8 columnaDatos d-flex align-items-center justify-content-center">
                                        <div class="datos">
                                            <p>En esta sección, puedes encontrar toda la información sobre tus reservas realizadas, desde las fechas y los horarios hasta el estado actual de cada reserva.</p>
                                        </div>
                                    </div>
                                    <div class="col-4 columnaBoton d-flex align-items-center justify-content-center">
                                        <div class="btnGes">
                                            <a class="btnGestion" href="reservasRealizadas.php">Gestionar reservas</a>
                                        </div>
                                    </div>
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
                        <li><a href="https://wa.link/ys192u" class="what" target="_blank" title="Whatsapp"><i class="bi bi-whatsapp"></i></a></li>
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

    <script src="https://cdn.userway.org/widget.js" data-account="5f8ySwz5CA"></script>

    <script>
        window.addEventListener('mouseover', initLandbot, {
            once: true
        });
        window.addEventListener('touchstart', initLandbot, {
            once: true
        });
        var myLandbot;

        function initLandbot() {
            if (!myLandbot) {
                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.addEventListener('load', function() {
                    var myLandbot = new Landbot.Livechat({
                        configUrl: 'https://storage.googleapis.com/landbot.online/v3/H-1781515-UV9UMH34F70SNUM3/index.json',
                    });
                });
                s.src = 'https://cdn.landbot.io/landbot-3/landbot-3.0.0.js';
                var x = document.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(s, x);
            }
        }
    </script>

</body>

</html>