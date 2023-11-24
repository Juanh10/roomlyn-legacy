<?php
session_start();
include_once "../../procesos/config/conex.php";

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
    <title>Seguridad</title>
</head>

<body>

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
            <h1>Ajustes de seguridad</h1>
            <div class="row">
                <div class="col-6 columnaDatos">
                    <div class="cardDatos">
                        <div class="row">
                            <div class="col-1">
                                <div class="iconoCard iconCardSeg">
                                    <i class="bi bi-lock-fill"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="datos datoSeguridad">
                                    <h2>Contraseña</h2>
                                    <p class="pSeguridad">Cambia tu contraseña con frecuencia para proteger tu cuenta</p>
                                    <a data-bs-toggle="modal" class="btnGestionSeg" data-bs-target="#modalCambiarContraseña" href="#">Cambiar contraseña</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cardDatos">
                        <div class="row">
                            <div class="col-1">
                                <div class="iconoCard iconCardSeg">
                                    <i class="bi bi-box-arrow-left"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="datos datoSeguridad">
                                    <h2>Cerrar sesión</h2>
                                    <p class="pSeguridad">Cierra sesión en este dispositivo</p>
                                    <a class="btnCerrarSesion btnGestionSeg" href="#">Cerrar sesión</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 columnaDatos">
                    <div class="cardDatos">
                        <div class="row">
                            <div class="col-1">
                                <div class="iconoCard iconCardSeg">
                                    <i class="bi bi-trash3-fill"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="datos datoSeguridad">
                                    <h2>Desactivar cuenta</h2>
                                    <p class="pSeguridad">Desactiva tu cuenta de forma permanente</p>
                                    <form action="../../procesos/registroClientes/contElmCuenta.php" method="post" class="formElmCuenta">
                                        <input type="hidden" name="idCliente" value="<?php echo $idCliente ?>">
                                        <input type="submit" class="btnGestionSeg" name="elmCuenta" value="Desactivar cuenta">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- Modal -->
    <div class="modal fade" id="modalCambiarContraseña" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar contraseña</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../procesos/registroClientes/conActContraseña.php" method="post" class="formContra">

                        <input type="hidden" name="idCliente" value="<?php echo $idCliente ?>">

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput1" name="contraActual" placeholder="Contraseña actual" required>
                            <label for="floatingInput1">Contraseña actual</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control inputContra" id="floatingInput2" name="contraNueva" placeholder="Contraseña actual" required>
                            <span class="verContraseña"><i class="bi bi-eye"></i></i></span>
                            <label for="floatingInput2">Contraseña nueva</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control inputContra2" id="floatingInput3" name="contraNueva2" placeholder="Contraseña actual" required>
                            <span class="verContraseña2"><i class="bi bi-eye"></i></i></span>
                            <label for="floatingInput3">Confirmar contraseña</label>
                        </div>
                        <p class="msjVerificacion">Las contraseñas no coinciden</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn boton-guardar" value="Cambiar">
                </div>
                </form>
            </div>
        </div>
    </div>

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


    <?php

    if (isset($_SESSION['msjAct'])) :
    ?>
        <script>
            Swal.fire({
                position: '',
                icon: 'success',
                title: '<?php echo $_SESSION['msjAct']; ?>',
                showConfirmButton: false,
                timer: 1000
            });
        </script>
    <?php
        unset($_SESSION['msjAct']);
    endif;

    ?>

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