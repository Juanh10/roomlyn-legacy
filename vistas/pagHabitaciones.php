<?php

session_start();

include_once "../procesos/config/conex.php";
include "vistasHabitaciones/funcionesIconos.php";

$estado = 1;

$sqlTiposHab = "SELECT habitaciones_tipos.id_hab_tipo, habitaciones_tipos.tipoHabitacion, habitaciones_tipos.cantidadCamas, habitaciones_tipos.capacidadPersonas, habitaciones_tipos.estado, MIN(habitaciones_imagenes.ruta) AS ruta FROM habitaciones_tipos INNER JOIN habitaciones_imagenes ON habitaciones_imagenes.id_hab_tipo = habitaciones_tipos.id_hab_tipo WHERE habitaciones_imagenes.estado = 1 AND habitaciones_tipos.estado = 1 GROUP BY habitaciones_tipos.id_hab_tipo, habitaciones_tipos.tipoHabitacion, habitaciones_tipos.cantidadCamas, habitaciones_tipos.capacidadPersonas, habitaciones_tipos.estado";

$sqlPrecios = $dbh->prepare("SELECT htp.id_tipo_servicio, htp.precio, htp.estado, habitaciones_servicios.servicio FROM habitaciones_tipos_precios htp INNER JOIN habitaciones_tipos_servicios hts ON hts.id_tipo_servicio = htp.id_tipo_servicio INNER JOIN habitaciones_servicios ON habitaciones_servicios.id_servicio = hts.id_servicio WHERE hts.id_hab_tipo = :idHabTipo AND htp.estado = :estadoHab");

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../iconos/logo_icono.png">
    <link rel="stylesheet" href="../librerias/bootstrap-icons-1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../librerias/lightbox2/dist/css/lightbox.css">
    <link rel="stylesheet" href="../librerias/datarangepicker/css/daterangepicker.css">
    <link rel="stylesheet" href="../css/estilosPaginaHabitaciones.css">
    <link rel="stylesheet" href="../css/estilosPrincipales.css">
    <link rel="stylesheet" href="../librerias/sweetAlert2/css/sweetalert2.min.css">
    <script src="../librerias/sweetAlert2/js/sweetalert2.all.min.js"></script>
    <title>Habitaciones | Hotel Colonial City</title>
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
                    <a href="../index.php"><img src="../iconos/logoPlahot2.png" alt="Logo de la plataforma web"></a>
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
                            <a href="vistasRegistroClientes/configuracionCuenta.php" class="inicioSesion"><span class="conexion"></span><?php echo $primerNombre . " " . $primerApellido ?></a>
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
                    <a href="../index.php"><img src="../iconos/logoPlahot2.png" alt="Logo de la plataforma web"></a>
                </div>
            </div>
        </header>

    <?php
    endif;
    ?>

    <main>
        <section class="resHabitaciones">

            <h1>HABITACIONES</h1>

            <div class="filtros-habitaciones">
                <div class="filtros-fecha-huespedes">
                    <form action="vistasHabitaciones/listaHabitacionesFiltro.php" method="get">
                        <div class="fechas">
                            <div class="grupo-rango-fechas">
                                <input type="text" name="fechasRango" id="rangoFechas" readonly>
                                <label for="rangoFechas" class="label-fechas">Seleccionar fechas</label>
                            </div>
                        </div>
                        <div class="huespedes">
                            <div class="grupo-huespedes">
                                <label for="inputHuespedes" class="label-huespedes">Seleccionar cantidad de huéspedes</label>
                                <input type="text" name="huespedes" id="inputHuespedes" value="1 huésped" readonly>
                            </div>
                            <div class="modalHuespedes">
                                <div class="infor-modal-huespedes">
                                    <div class="filtro-huespedes">
                                        <span>Habitación 1</span>
                                        <div class="grupo-cantidad-huespedes">
                                            <label for="inputCantHuespedes" class="cant-huespedes">Huéspedes</label>
                                            <input type="number" name="cantHuespedes" id="inputCantHuespedes" min="0" max="8" value="1">
                                        </div>
                                    </div>
                                    <div class="btn-añadir-guardar">
                                        <span class="btn-cancelar-habitacion">Cancelar</span>
                                        <span class="btn-aplicar-cambios">Aplicar</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tipo-climatizacion">
                            <div class="grupo-climatizacion">
                                <label for="selectClima" class="label-huespedes">Seleccionar el sistema de climatización</label>

                                <select name="selectClima" id="selectClima">
                                    <option value="1">Ventilador</option>
                                    <option value="2">Aire acondicionado</option>
                                </select>

                            </div>
                        </div>

                        <div class="botones-filtro">
                            <input type="submit" value="Buscar" class="btn-buscar-filtro">
                        </div>
                    </form>
                </div>
            </div>

            <div class="contCardHab">

                <?php

                foreach ($dbh->query($sqlTiposHab) as $row) :
                    $cantCama = $row['cantidadCamas'];
                    $capacidadPerson = $row['capacidadPersonas'];
                ?>
                    <div class="cardHab">
                        <div class="imgCard">
                            <img src="../imgServidor/<?php echo $row['ruta'] ?>" alt="Imagen que ilustra la categoría de <?php echo $row['tipoHabitacion']  ?> ">
                        </div>

                        <div class="contenidoCard">

                            <div class="tituloHab">
                                <h2><?php echo $row['tipoHabitacion'] ?></h2>
                                <a class="btnImgHab" href="../imgServidor/<?php echo $row['ruta'] ?>" data-lightbox="image-<?php echo $row['id_hab_tipo'] ?>" title="Ver imagen"><i class="bi bi-image"></i></a>
                            </div>

                            <div class="infoCard">
                                <p><span>Cantidad de camas: </span><?php echo $cantCama; ?></p>
                                <p><span>Capacidad máxima: </span><?php iconCapacidad($capacidadPerson); ?></pass=>
                                <form action="vistasHabitaciones/mostrarListaHabitaciones.php" method="get">
                                    <input type="hidden" value="<?php echo $row['id_hab_tipo'] ?>" name="idTipoHab">
                                    <p class="selFiltro">Seleccione: </p>
                                    <ul class="filtrosHab">
                                        <li>
                                            <input type="checkbox" name="opServicios[]" value="ventilador" id="checkVentilador<?php echo $row['id_hab_tipo'] ?>" class="check">
                                            <label for="checkVentilador<?php echo $row['id_hab_tipo'] ?>">Ventilador</label>
                                        </li>
                                        <li>
                                            <input type="checkbox" name="opServicios[]" value="aire" id="checkAire<?php echo $row['id_hab_tipo'] ?>" class="check">
                                            <label for="checkAire<?php echo $row['id_hab_tipo'] ?>">Aire acondicionado</label>
                                        </li>
                                    </ul>
                                    <div class="btnInfo">
                                        <button type="submit" class="btnVermas" title="Ver lista de las habitaciones"> Ver más </button>
                                    </div>
                                </form>
                            </div>


                            <div class="precios">
                                <?php

                                $idTipoHab = $row['id_hab_tipo'];

                                $sqlPrecios->bindParam(':estadoHab', $estado);
                                $sqlPrecios->bindParam(':idHabTipo', $idTipoHab);

                                $sqlPrecios->execute();

                                while ($resPrecio = $sqlPrecios->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <div class="precioVent">
                                        <p>Precio por dia con <?php echo $resPrecio['servicio'] ?></p>
                                        <span>COP <?php echo number_format($resPrecio['precio'], 0, ',', '.') ?> + IVA</span>
                                    </div>
                                <?php
                                }

                                ?>
                            </div>

                        </div>

                    </div>
                <?php
                endforeach;
                ?>
            </div>
        </section>
    </main>

    <!--* LOGO WHATSAPP  -->

    <div class="logoWhat">
        <a href="https://wa.link/ys192u" target="_blank" class="btnWha" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
    </div>

    <!-- ALERTAS -->

    <?php
    if (isset($_SESSION['msjError'])) {
    ?>

        <script>
            Swal.fire('<?php echo $_SESSION['msjError']; ?>')
        </script>

    <?php
        unset($_SESSION['msjError']);
    }

    ?>


    <?php

    if (isset($_SESSION['msjReservasExito'])) :
    ?>
        <script>
            Swal.fire({
                position: '',
                icon: 'success',
                title: '¡RESERVA REGISTRADA!',
                html: "<p>Para confirmar su reserva, es necesario realizar un pago inicial del 50%. Le solicitamos que efectúe dicho pago en un plazo de 24 horas. Para obtener más detalles y proceder con la transacción, por favor, comuníquese al <a href='https://wa.link/ys192u' target='_blank'>3156676013</a>. o al <a href='https://wa.link/icvti0' target='_blank'>3103341338</a></p>",
                showConfirmButton: true
            });
        </script>
    <?php
        unset($_SESSION['msjReservasExito']);
    endif;

    ?>

    <!--* PIE DE PAGINA -->

    <footer>
        <div class="piePagina">
            <div class="copyPiePagina">
                <div class="logoPiePagina">
                    <img src="../iconos/logoPlahot2.png" alt="Logo de la plataforma web">
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
                <a href="../comoFunciona.html">Como funciona ROOMLYN</a>
                <a href="#">Politicas de privacidad</a>
            </div>
        </div>
    </footer>

    <script src="../librerias/jquery-3.7.0.min.js"></script>
    <script src="../librerias/lightbox2/dist/js/lightbox.js"></script>
    <script src="../librerias/scrollreveal.js"></script>
    <script src="../librerias/datarangepicker/js/moment.min.js"></script>
    <script src="../librerias/datarangepicker/js/daterangepicker.js"></script>
    <script src="../js/scriptHabitaciones.js"></script>

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