<?php

session_start();

if (!empty($_SESSION['id_cliente_registrado'])) {
    $idCliente = $_SESSION['id_cliente_registrado'];
    $idInfoCliente = $_SESSION['id_info_cliente'];
    $nombres = explode(" ", $_SESSION['nombres']);
    $apellidos = explode(" ", $_SESSION['apellidos']);

    $primerNombre = $nombres[0];
    $primerApellido = $apellidos[0];
}

date_default_timezone_set('America/Bogota'); // Establecer la zona horaria

include_once "../../procesos/config/conex.php";
include "funcionesIconos.php";

$estadoId = false;
$pagFiltro = false;

// Obtener la URL de la pagina anterior
$_SESSION['url_anterior'] = $_SERVER['HTTP_REFERER'];

if (!empty($_GET['idHabitacion']) && !empty($_GET['idTipoHab'])) { // Condicion para saber si los campos no estan vacios

    $habitacion = $_GET['idHabitacion']; // capturar por medio de GET
    $tipoHabitacion = $_GET['idTipoHab'];

    if (!empty($_GET['filtro'])) {
        $pagFiltro = true;
        $fechaRango = $_GET['fechasRango'];
        $huespedes = $_GET['huespedes'];
        $sisClimatizacion = $_GET['sisClimatizacion'];

        $arrayFechas = explode(" - ", $fechaRango);

        $checkin = $arrayFechas[0];
        $checkin = str_replace("/", "-", $checkin); // Reemplazamos "/" por "-"

        $checkout = $arrayFechas[1];
        $checkout = str_replace("/", "-", $checkout); // Reemplazamos "/" por "-"

    } else {
        $fechaRango = $_GET['fechasRango'];
        $arrayFechas = explode(" - ", $fechaRango);
        $checkin = $arrayFechas[0];
        $checkout = $arrayFechas[1];
    }

    $sqlHabitacion = "SELECT id_habitacion, id_hab_tipo, id_hab_estado, nHabitacion, tipoCama, cantidadPersonasHab, observacion, estado FROM habitaciones WHERE id_habitacion = " . $habitacion . " AND estado = 1";

    $rowHabitacion = $dbh->query($sqlHabitacion)->fetch();

    $sqlTipoHab = "SELECT id_hab_tipo, tipoHabitacion, cantidadCamas, estado FROM habitaciones_tipos WHERE id_hab_tipo = " . $tipoHabitacion . " AND estado = 1";

    $rowTipoHab = $dbh->query($sqlTipoHab)->fetch();

    $sqlimagenesTipoHab = "SELECT nombre, ruta, estado FROM habitaciones_imagenes WHERE estado = 1 AND id_hab_tipo = " . $tipoHabitacion . "";

    $rowImgTipoHab = $dbh->query($sqlimagenesTipoHab)->fetch();

    $estadoId = true;
} else {
    echo "Ocurrió un error";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../iconos/logo_icono.png">
    <?php require_once "dependecias.php" ?>
    <title>Habitaciones | Hotel Colonial City</title>
</head>

<style>
    .cabeceraHab{
        padding: 45px 20px !important;
    }
</style>

<body>

    <?php

    if ($estadoId) :
    ?>

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

        <?php

        if (!empty($_SESSION['id_cliente_registrado'])) :
            $nombres = explode(" ", $_SESSION['nombres']);
            $apellidos = explode(" ", $_SESSION['apellidos']);

            $primerNombre = $nombres[0];
            $primerApellido = $apellidos[0];
        ?>

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
                                <a href="../vistasRegistroClientes/configuracionCuenta.php" class="inicioSesion"><span class="conexion"></span><?php echo $primerNombre . " " . $primerApellido ?></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </header>
        <?php
        else :
        ?>
            <header class="cabeceraHab">
                <div class="contenedorHab navContenedorHab">
                    <div class="logoPlahotHab">
                        <a href="../../index.php"><img src="../../iconos/logoPlahot2.png" alt="Logo de la plataforma web"></a>
                    </div>
                    <nav class="navegacionHab"></nav>
                </div>
            </header>
        <?php
        endif;
        ?>

        <main class="container containerReserva">
            <div class="row rowPrincipal">
                <div class="col-md-8 col-informacion">
                    <div class="card-infor-reserva">
                        <div class="row">
                            <div class="col-4 responsive-col-img">
                                <div class="imagenes">
                                    <img src="../../imgServidor/<?php echo $rowImgTipoHab['ruta'] ?>" alt="Fotos de <?php echo $rowTipoHab['tipoHabitacion'] ?>">
                                </div>
                            </div>
                            <div class="col">
                                <div class="informacion">
                                    <div class="habitacion">
                                        <h1>Habitación <?php echo $rowHabitacion['nHabitacion'] ?> | <?php echo $rowTipoHab['tipoHabitacion'] ?></h1>
                                    </div>
                                    <div class="servicios">
                                        <p>
                                            <span>Tipo de cama:</span> <?php iconCantidadCama($rowHabitacion['tipoCama']) ?>
                                        </p>
                                        <p>
                                            <span>Capacidad:</span> <?php echo iconCapacidad($rowHabitacion['cantidadPersonasHab']) ?>
                                        </p>
                                    </div>
                                    <div class="descripcion">
                                        <p><?php echo $rowHabitacion['observacion']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="formularioReserva">
                        <h2>Datos</h2>

                        <?php

                        if (!empty($_SESSION['id_cliente_registrado'])) :
                            $idCliente = $_SESSION['id_cliente_registrado'];
                            $nombres = $_SESSION['nombres'];
                            $apellidos = $_SESSION['apellidos'];
                            $email = $_SESSION['email'];
                            $celular = $_SESSION['celular'];

                        ?>
                            <form action="../../procesos/registroReservas/conRegistroReservasCliente.php" method="post" class="formReservas">
                                <div class="row">
                                    <div class="col-6 responsive-col-form">

                                        <input type="hidden" id="idCliente" name="idCliente" value="<?php echo $idInfoCliente ?>">
                                        <input type="hidden" id="tipoHab" name="tipoHab" value="<?php echo $tipoHabitacion ?>">
                                        <input type="hidden" id="habitacion" name="habitacion" value="<?php echo $habitacion ?>">

                                        <div class="form-floating mb-3">
                                            <?php
                                            if ($pagFiltro) :
                                            ?>
                                                <input type="date" class="form-control" id="fechaEntrada" placeholder="Nombres" name="checkIn" value="<?php echo $checkin ?>" required>
                                            <?php
                                            else :
                                            ?>
                                                <input type="date" class="form-control" id="fechaEntrada" placeholder="Nombres" name="checkIn" value="<?php echo $checkin ?>" required>
                                            <?php
                                            endif;
                                            ?>
                                            <p></p>
                                            <label for="fechaEntrada">Fecha de llegada</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Nombres" value="<?php echo $nombres ?>" disabled required>
                                            <p></p>
                                            <label for="nombres">Nombres</label>
                                        </div>


                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo $email ?>" disabled required>
                                            <p></p>
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-6">

                                        <div class="form-floating mb-3">
                                            <?php
                                            if ($pagFiltro) :
                                            ?>
                                                <input type="date" class="form-control" id="fechaSalida" placeholder="Nombres" name="checkOut" value="<?php echo $checkout ?>" required>
                                            <?php
                                            else :
                                            ?>
                                                <input type="date" class="form-control" id="fechaSalida" placeholder="Nombres" name="checkOut" value="<?php echo $checkout ?>" required>
                                            <?php
                                            endif;
                                            ?>
                                            <p></p>
                                            <label for="fechaSalida">Fecha de salida</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Apellidos" value="<?php echo $apellidos ?>" disabled required>
                                            <p></p>
                                            <label for="apellidos">Apellidos</label>
                                        </div>


                                        <div class="form-floating mb-3">
                                            <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Teléfono" value="<?php echo $celular ?>" disabled required>
                                            <p></p>
                                            <label for="telefono">Teléfono</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="btnReservar">
                                    <input type="submit" name="btnReservar" value="Reservar">
                                </div>
                            </form>
                        <?php
                        else :
                        ?>
                            <form action="../../procesos/registroReservas/conRegistroReservas.php" method="post" id="form" class="formReservasClienteNoReg">
                                <div class="row">
                                    <div class="col-6 responsive-col-form">

                                        <input type="hidden" id="tipoHab" name="tipoHab" value="<?php echo $tipoHabitacion ?>">
                                        <input type="hidden" id="habitacion" name="habitacion" value="<?php echo $habitacion ?>">

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Nombres" required>
                                            <p></p>
                                            <label for="nombres">Nombres</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <?php
                                            if ($pagFiltro) :
                                            ?>
                                                <input type="date" class="form-control" id="fechaEntrada" placeholder="Nombres" name="checkIn" value="<?php echo $checkin ?>" required>
                                            <?php
                                            else :
                                            ?>
                                                <input type="date" class="form-control" id="fechaEntrada" placeholder="Nombres" name="checkIn" value="<?php echo $checkin ?>" required>
                                            <?php
                                            endif;
                                            ?>
                                            <p></p>
                                            <label for="fechaEntrada">Fecha de llegada</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" name="documento" class="form-control" id="documento" placeholder="Documento" required>
                                            <p></p>
                                            <label for="documento">Documento</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                                            <p></p>
                                            <label for="email">Email</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="nacionalidad" id="nacionalidad" required>
                                                <option selected disabled value="">Escoja una opción</option>
                                                <?php
                                                $sqlNacionalidad = "SELECT id_nacionalidad, nacionalidad FROM nacionalidades WHERE 1";

                                                foreach ($dbh->query($sqlNacionalidad) as $rowNacionalidad) :
                                                    if ($rowNacionalidad['id_nacionalidad'] != 1) :
                                                ?>
                                                        <option value="<?php echo $rowNacionalidad['id_nacionalidad'] ?>"><?php echo $rowNacionalidad['nacionalidad'] ?></option>
                                                <?php
                                                    endif;
                                                endforeach;

                                                ?>
                                            </select>
                                            <label for="nacionalidad">Nacionalidad</label>
                                        </div>

                                        <div class="form-floating mb-3" id="selectCiudad">
                                            <select class="form-select" name="ciudad" id="ciudad" required>

                                            </select>
                                            <label for="ciudad">Ciudad de origen</label>
                                        </div>

                                    </div>
                                    <div class="col-6">

                                        <div class="form-floating mb-3">
                                            <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Apellidos" required>
                                            <p></p>
                                            <label for="apellidos">Apellidos</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <?php
                                            if ($pagFiltro) :
                                            ?>
                                                <input type="date" class="form-control" id="fechaSalida" placeholder="Nombres" name="checkOut" value="<?php echo $checkout ?>" required>
                                            <?php
                                            else :
                                            ?>
                                                <input type="date" class="form-control" id="fechaSalida" placeholder="Nombres" name="checkOut" value="<?php echo $checkout ?>" required>
                                            <?php
                                            endif;
                                            ?>
                                            <p></p>
                                            <label for="fechaSalida">Fecha de salida</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Teléfono" required>
                                            <p></p>
                                            <label for="telefono">Teléfono</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="sexo" id="sexo" required>
                                                <option selected disabled value="">Escoja una opción</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                            </select>
                                            <p></p>
                                            <label for="sexo">Sexo</label>
                                        </div>

                                        <div class="form-floating mb-3" id="selectDepartamento">
                                            <select class="form-select" name="departamento" id="departamento" required>

                                            </select>
                                            <label for="departamento">Departamento</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="formularioMensaje">
                                    <p><i class="bi bi-exclamation-circle-fill"></i>¡Por favor rellene los campos correctamente!</p>
                                </div>

                                <div class="btnReservar">
                                    <input type="submit" name="btnReservar" value="Reservar" id="btnResClnNoReg">
                                </div>
                            </form>
                        <?php
                        endif;

                        ?>
                    </div>
                </div>
                <div class="col col-factura">

                </div>
            </div>
        </main>

    <?php
    endif;

    ?>

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

    <!-- ALERTAS -->

    <?php

    if (isset($_SESSION['msjReservas'])) :
    ?>
        <script>
            Swal.fire({
                position: '',
                icon: 'error',
                title: '¡Ocurrió un error!',
                text: '<?php echo $_SESSION['msjReservas']; ?>',
                showConfirmButton: true
            });
        </script>
    <?php
        unset($_SESSION['msjReservas']);
    endif;

    ?>

    <script src="../../js/validarRegistroReserva.js"></script>

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